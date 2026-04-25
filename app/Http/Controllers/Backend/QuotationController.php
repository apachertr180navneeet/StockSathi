<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product; 
use App\Models\Customer; 
use App\Models\WareHouse;
use App\Models\Quotation; 
use App\Models\QuotationItem; 
use App\Models\Sale;
use App\Models\SaleItem;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class QuotationController extends Controller
{
    public function AllQuotation(){
        $allData = Quotation::orderBy('id','desc')->get();
        return view('admin.backend.quotation.all_quotation',compact('allData')); 
    }

    public function AddQuotation(){
        $customers = Customer::all();
        $warehouses = WareHouse::all();
        return view('admin.backend.quotation.add_quotation',compact('customers','warehouses'));
    }

    public function StoreQuotation(Request $request){
        $request->validate([
            'date' => 'required|date',
            'status' => 'required', 
        ]);

        try {
            DB::beginTransaction();

            $grandTotal = 0;

            $quotation = Quotation::create([
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
                    throw new \Exception("Net Unit cost is missing for the product id" . $productData['id']);
                }

                $subtotal = ($netUnitCost * $productData['quantity']) - ($productData['discount'] ?? 0);
                $grandTotal += $subtotal;

                QuotationItem::create([
                    'quotation_id' => $quotation->id,
                    'product_id' => $productData['id'],
                    'net_unit_cost' => $netUnitCost,
                    'stock' => $product->product_qty, 
                    'quantity' => $productData['quantity'],
                    'discount' => $productData['discount'] ?? 0,
                    'subtotal' => $subtotal, 
                ]);
            }

            $quotation->update(['grand_total' => ($grandTotal - $request->discount) + $request->tax_amount + $request->shipping]);

            DB::commit();

            $notification = array(
                'message' => 'Quotation Stored Successfully',
                'alert-type' => 'success'
            ); 
            return redirect()->route('all.quotation')->with($notification);  

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        } 
    }

    public function EditQuotation($id){
        $editData = Quotation::with('quotationItems.product')->findOrFail($id);
        $customers = Customer::all();
        $warehouses = WareHouse::all();
        return view('admin.backend.quotation.edit_quotation',compact('editData','customers','warehouses'));
    }

    public function UpdateQuotation(Request $request, $id){
        $request->validate([
            'date' => 'required|date',
            'status' => 'required', 
        ]);

        try {
            DB::beginTransaction();

            $quotation = Quotation::findOrFail($id);
            $quotation->update([
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

            QuotationItem::where('quotation_id', $quotation->id)->delete();

            foreach($request->products as $product_id => $productData){
                QuotationItem::create([
                    'quotation_id' => $quotation->id,
                    'product_id' => $product_id,
                    'net_unit_cost' => $productData['net_unit_cost'],
                    'stock' => $productData['stock'],
                    'quantity' => $productData['quantity'],
                    'discount' => $productData['discount'] ?? 0,
                    'subtotal' => $productData['subtotal'],  
                ]);
            }

            DB::commit();

            $notification = array(
                'message' => 'Quotation Updated Successfully',
                'alert-type' => 'success'
            ); 
            return redirect()->route('all.quotation')->with($notification);  

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function DeleteQuotation($id){
        try {
          DB::beginTransaction();
          $quotation = Quotation::findOrFail($id);
          QuotationItem::where('quotation_id',$id)->delete();
          $quotation->delete();
          DB::commit();

          $notification = array(
            'message' => 'Quotation Deleted Successfully',
            'alert-type' => 'success'
         ); 
         return redirect()->route('all.quotation')->with($notification);  
            
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }  
    }

    public function DetailsQuotation($id){
        try {
            $quotation = Quotation::with(['customer','quotationItems.product'])->find($id);

            if (!$quotation) {
                return redirect()->back()->with('error', 'Quotation record not found!');
            }

            return view('admin.backend.quotation.quotation_details', compact('quotation'));

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }

    public function InvoiceQuotation($id){
        try {
            $quotation = Quotation::with(['customer','warehouse','quotationItems.product'])->find($id);

            if (!$quotation) {
                return redirect()->back()->with('error', 'Quotation record not found!');
            }

            $pdf = Pdf::loadView('admin.backend.quotation.invoice_pdf', compact('quotation'));
            return $pdf->download('quotation_'.$id.'.pdf');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }

    public function ConvertToSale($id) {
        try {
            DB::beginTransaction();
            
            $quotation = Quotation::with('quotationItems.product')->findOrFail($id);
            
            $sale = Sale::create([
                'date' => now(),
                'warehouse_id' => $quotation->warehouse_id,
                'customer_id' => $quotation->customer_id,
                'discount' => $quotation->discount,
                'shipping' => $quotation->shipping,
                'tax_rate' => $quotation->tax_rate,
                'tax_amount' => $quotation->tax_amount,
                'status' => 'Pending',
                'note' => $quotation->note . ' (Converted from Quotation #' . $quotation->id . ')',
                'grand_total' => $quotation->grand_total,
                'paid_amount' => 0,
                'due_amount' => $quotation->grand_total,
            ]);

            foreach($quotation->quotationItems as $item){
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

            $quotation->update(['status' => 'Accepted']);

            DB::commit();

            $notification = array(
                'message' => 'Quotation successfully converted to Sale!',
                'alert-type' => 'success'
            ); 
            return redirect()->route('all.sale')->with($notification);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with(['message' => 'Conversion failed: ' . $e->getMessage(), 'alert-type' => 'error']);
        }
    }
}
