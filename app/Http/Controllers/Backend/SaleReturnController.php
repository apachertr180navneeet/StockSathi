<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request; 
use App\Models\Product; 
use App\Models\Customer; 
use App\Models\WareHouse;
use App\Models\Sale; 
use App\Models\SaleItem; 
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\SaleReturn; 
use App\Models\SaleReturnItem; 

class SaleReturnController extends Controller
{
    public function AllSalesReturn(){
        try {
            $allData = SaleReturn::orderBy('id','desc')->get();
            return view('admin.backend.return-sale.all_return_sales',compact('allData')); 
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function AddSalesReturn(){
        try {
            $customers = Customer::all();
            $warehouses = WareHouse::all();
            return view('admin.backend.return-sale.add_retrun_sales',compact('customers','warehouses'));
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function StoreSalesReturn(Request $request){
        $request->validate([
            'date' => 'required|date',
            'status' => 'required', 
        ]);

        try {
            DB::beginTransaction();

            $grandTotal = 0;

            $sales = SaleReturn::create([
                'date' => $request->date,
                'warehouse_id' => $request->warehouse_id,
                'customer_id' => $request->customer_id,
                'discount' => $request->discount ?? 0,
                'shipping' => $request->shipping ?? 0,
                'status' => $request->status,
                'note' => $request->note,
                'grand_total' => 0,
                'paid_amount' => $request->paid_amount,
                'due_amount' => $request->due_amount, 
            ]);

            foreach($request->products as $productData){
                $product = Product::findOrFail($productData['id']);
                $netUnitCost = $productData['net_unit_cost'] ?? $product->price;

                if ($netUnitCost === null) {
                    throw new \Exception("Net Unit cost missing for product ID " . $productData['id']);
                }

                $subtotal = ($netUnitCost * $productData['quantity']) - ($productData['discount'] ?? 0);
                $grandTotal += $subtotal;

                SaleReturnItem::create([
                    'sale_return_id' => $sales->id,
                    'product_id' => $productData['id'],
                    'net_unit_cost' => $netUnitCost,
                    'stock' => $product->product_qty + $productData['quantity'],
                    'quantity' => $productData['quantity'],
                    'discount' => $productData['discount'] ?? 0,
                    'subtotal' => $subtotal, 
                ]);

                $product->increment('product_qty', $productData['quantity']); 
            }

            $sales->update([
                'grand_total' => $grandTotal + $request->shipping - $request->discount
            ]);

            DB::commit();

            return redirect()->route('all.sale.return')->with([
                'message' => 'Sales Return Stored Successfully',
                'alert-type' => 'success'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        } 
    }

    public function EditSalesReturn($id){
        try {
            $editData = SaleReturn::with('saleReturnItems.product')->findOrFail($id);
            $customers = Customer::all();
            $warehouses = WareHouse::all();
            return view('admin.backend.return-sale.edit_return_sales',compact('editData','customers','warehouses'));
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function UpdateSalesReturn(Request $request, $id){
        $request->validate([
            'date' => 'required|date',
            'status' => 'required', 
        ]);

        try {
            DB::beginTransaction();

            $sales = SaleReturn::findOrFail($id);

            $sales->update([
                'date' => $request->date,
                'warehouse_id' => $request->warehouse_id,
                'customer_id' => $request->customer_id,
                'discount' => $request->discount ?? 0,
                'shipping' => $request->shipping ?? 0,
                'status' => $request->status,
                'note' => $request->note,
                'grand_total' => $request->grand_total,
                'paid_amount' => $request->paid_amount,
                'due_amount' => $request->due_amount,
                'full_paid' => $request->full_paid,   
            ]);

            // Delete old items
            SaleReturnItem::where('sale_return_id',$sales->id)->delete();

            foreach($request->products as $product_id => $product){
                SaleReturnItem::create([
                    'sale_return_id' => $sales->id,
                    'product_id' => $product_id,
                    'net_unit_cost' => $product['net_unit_cost'],
                    'stock' => $product['stock'],
                    'quantity' => $product['quantity'],
                    'discount' => $product['discount'] ?? 0,
                    'subtotal' => $product['subtotal'],  
                ]);

                $productModel = Product::find($product_id);
                if ($productModel) {
                    $productModel->increment('product_qty', $product['quantity']);
                }  
            }

            DB::commit();

            return redirect()->route('all.sale.return')->with([
                'message' => 'Sale Return Updated Successfully',
                'alert-type' => 'success'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    public function DetailsSalesReturn($id){
        try {
            $sales = SaleReturn::with(['customer','saleReturnItems.product'])->findOrFail($id);
            return view('admin.backend.return-sale.sales_return_details',compact('sales'));
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function DeleteSalesReturn($id){
        try {
            DB::beginTransaction();

            $sales = SaleReturn::findOrFail($id);
            $SalesItems = SaleReturnItem::where('sale_return_id',$id)->get();

            foreach($SalesItems as $item){
                $product = Product::find($item->product_id);
                if ($product) {
                    $product->decrement('product_qty',$item->quantity);
                }
            }

            SaleReturnItem::where('sale_return_id',$id)->delete();
            $sales->delete();

            DB::commit();

            return redirect()->route('all.sale.return')->with([
                'message' => 'Sale Return Deleted Successfully',
                'alert-type' => 'success'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }  
    }

    public function InvoiceSalesReturn($id){
        try {
            $sales = SaleReturn::with(['customer','saleReturnItems.product'])->findOrFail($id);

            if (!$sales) {
                return redirect()->back()->with('error', 'Sales record not found!');
            }

            $pdf = Pdf::loadView('admin.backend.return-sale.invoice_pdf', compact('sales'));
            return $pdf->download('sales_'.$id.'.pdf');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }
}