<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product; 
use App\Models\Customer; 
use App\Models\WareHouse;
use App\Models\SalesOrder; 
use App\Models\SalesOrderItem; 
use App\Models\Sale;
use App\Models\SaleItem;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class SalesOrderController extends Controller
{
    public function AllSalesOrder(){
        $allData = SalesOrder::orderBy('id','desc')->get();
        return view('admin.backend.sales_order.all_sales_order',compact('allData')); 
    }

    public function AddSalesOrder(){
        $customers = Customer::all();
        $warehouses = WareHouse::all();
        return view('admin.backend.sales_order.add_sales_order',compact('customers','warehouses'));
    }

    public function StoreSalesOrder(Request $request){
        $request->validate([
            'date' => 'required|date',
            'status' => 'required', 
        ]);

        try {
            DB::beginTransaction();

            $grandTotal = 0;

            $salesOrder = SalesOrder::create([
                'date' => $request->date,
                'warehouse_id' => $request->warehouse_id,
                'customer_id' => $request->customer_id,
                'discount' => $request->discount ?? 0,
                'shipping' => $request->shipping ?? 0,
                'tax_rate' => $request->tax_rate ?? 0,
                'tax_amount' => $request->tax_amount ?? 0,
                'status' => $request->status,
                'note' => $request->note,
                'grand_total' => 0,
            ]);

            foreach($request->products as $productData){
                $product = Product::findOrFail($productData['id']);
                $netUnitCost = $productData['net_unit_cost'] ?? $product->price;

                if ($netUnitCost === null) {
                    throw new \Exception("Net Unit cost is missing for the product id " . $productData['id']);
                }

                $subtotal = ($netUnitCost * $productData['quantity']) - ($productData['discount'] ?? 0);
                $grandTotal += $subtotal;

                SalesOrderItem::create([
                    'sales_order_id' => $salesOrder->id,
                    'product_id' => $productData['id'],
                    'net_unit_cost' => $netUnitCost,
                    'quantity' => $productData['quantity'],
                    'discount' => $productData['discount'] ?? 0,
                    'subtotal' => $subtotal, 
                ]);
            }

            $salesOrder->update(['grand_total' => ($grandTotal - $request->discount) + $request->tax_amount + $request->shipping]);

            DB::commit();

            $notification = array(
                'message' => 'Sales Order Stored Successfully',
                'alert-type' => 'success'
            ); 
            return redirect()->route('all.sales.order')->with($notification);  

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        } 
    }

    public function EditSalesOrder($id){
        $editData = SalesOrder::with('salesOrderItems.product')->findOrFail($id);
        $customers = Customer::all();
        $warehouses = WareHouse::all();
        return view('admin.backend.sales_order.edit_sales_order',compact('editData','customers','warehouses'));
    }

    public function UpdateSalesOrder(Request $request, $id){
        $request->validate([
            'date' => 'required|date',
            'status' => 'required', 
        ]);

        try {
            DB::beginTransaction();

            $salesOrder = SalesOrder::findOrFail($id);
            $salesOrder->update([
                'date' => $request->date,
                'warehouse_id' => $request->warehouse_id,
                'customer_id' => $request->customer_id,
                'discount' => $request->discount ?? 0,
                'shipping' => $request->shipping ?? 0,
                'tax_rate' => $request->tax_rate ?? 0,
                'tax_amount' => $request->tax_amount ?? 0,
                'status' => $request->status,
                'note' => $request->note,
                'grand_total' => $request->grand_total,
            ]);

            SalesOrderItem::where('sales_order_id', $salesOrder->id)->delete();

            foreach($request->products as $product_id => $productData){
                SalesOrderItem::create([
                    'sales_order_id' => $salesOrder->id,
                    'product_id' => $product_id,
                    'net_unit_cost' => $productData['net_unit_cost'],
                    'quantity' => $productData['quantity'],
                    'discount' => $productData['discount'] ?? 0,
                    'subtotal' => $productData['subtotal'],  
                ]);
            }

            DB::commit();

            $notification = array(
                'message' => 'Sales Order Updated Successfully',
                'alert-type' => 'success'
            ); 
            return redirect()->route('all.sales.order')->with($notification);  

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function DeleteSalesOrder($id){
        try {
          DB::beginTransaction();
          $salesOrder = SalesOrder::findOrFail($id);
          SalesOrderItem::where('sales_order_id',$id)->delete();
          $salesOrder->delete();
          DB::commit();

          $notification = array(
            'message' => 'Sales Order Deleted Successfully',
            'alert-type' => 'success'
         ); 
         return redirect()->route('all.sales.order')->with($notification);  
            
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }  
    }

    public function DetailsSalesOrder($id){
        try {
            $salesOrder = SalesOrder::with(['customer','salesOrderItems.product'])->find($id);

            if (!$salesOrder) {
                return redirect()->back()->with('error', 'Sales Order record not found!');
            }

            return view('admin.backend.sales_order.sales_order_details', compact('salesOrder'));

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }

    public function InvoiceSalesOrder($id){
        try {
            $salesOrder = SalesOrder::with(['customer','warehouse','salesOrderItems.product'])->find($id);

            if (!$salesOrder) {
                return redirect()->back()->with('error', 'Sales Order record not found!');
            }

            $pdf = Pdf::loadView('admin.backend.sales_order.invoice_pdf', compact('salesOrder'));
            return $pdf->download('sales_order_'.$id.'.pdf');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }

    public function ConvertToSale($id) {
        try {
            DB::beginTransaction();
            
            $salesOrder = SalesOrder::with('salesOrderItems.product')->findOrFail($id);
            
            $sale = Sale::create([
                'date' => now(),
                'warehouse_id' => $salesOrder->warehouse_id,
                'customer_id' => $salesOrder->customer_id,
                'discount' => $salesOrder->discount,
                'shipping' => $salesOrder->shipping,
                'tax_rate' => $salesOrder->tax_rate,
                'tax_amount' => $salesOrder->tax_amount,
                'status' => 'Pending',
                'note' => $salesOrder->note . ' (Converted from Sales Order #' . $salesOrder->id . ')',
                'grand_total' => $salesOrder->grand_total,
                'paid_amount' => 0,
                'due_amount' => $salesOrder->grand_total,
            ]);

            foreach($salesOrder->salesOrderItems as $item){
                $product = Product::findOrFail($item->product_id);

                SaleItem::create([
                    'sale_id' => $sale->id,
                    'product_id' => $item->product_id,
                    'net_unit_cost' => $item->net_unit_cost,
                    'stock' => $product->product_qty,
                    'quantity' => $item->quantity,
                    'discount' => $item->discount,
                    'subtotal' => $item->subtotal, 
                ]);

                // Deduct stock upon converting to sale
                $product->decrement('product_qty', $item->quantity); 
            }

            $salesOrder->update(['status' => 'Confirmed']);

            DB::commit();

            $notification = array(
                'message' => 'Sales Order successfully converted to Sale!',
                'alert-type' => 'success'
            ); 
            return redirect()->route('all.sale')->with($notification);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with(['message' => 'Conversion failed: ' . $e->getMessage(), 'alert-type' => 'error']);
        }
    }
}
