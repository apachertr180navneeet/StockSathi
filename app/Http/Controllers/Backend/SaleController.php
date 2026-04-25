<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductCategory;
use App\Models\Product; 
use App\Models\Customer; 
use App\Models\WareHouse;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use App\Models\Sale; 
use App\Models\SaleItem; 
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Services\FinancialService;

class SaleController extends Controller
{
    protected $financialService;

    public function __construct(FinancialService $financialService)
    {
        $this->financialService = $financialService;
    }
    public function AllSales(){
        $allData = Sale::orderBy('id','desc')->get();
        return view('admin.backend.sales.all_sales',compact('allData')); 
    }
    // End Method 

    public function AddSales(){
        $customers = Customer::all();
        $warehouses = WareHouse::all();
        return view('admin.backend.sales.add_sales',compact('customers','warehouses'));
    }
     // End Method 

    public function StoreSales(Request $request){

        $request->validate([
            'date' => 'required|date',
            'status' => 'required', 
        ]);

        try {

            DB::beginTransaction();

            $grandTotal = 0;

            $sales = Sale::create([
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
                'paid_amount' => $request->paid_amount,
                'due_amount' => $request->due_amount, 

            ]);

            /// Store Sales Items & Update Stock 
            foreach($request->products as $productData){
                $product = Product::findOrFail($productData['id']);
                $netUnitCost = $productData['net_unit_cost'] ?? $product->price;

                if ($netUnitCost === null) {
                    throw new \Exception("Net Unit cost is missing ofr the product id" . $productData['id']);
                }

                $subtotal = ($netUnitCost * $productData['quantity']) - ($productData['discount'] ?? 0);
                $grandTotal += $subtotal;

                SaleItem::create([
                    'sale_id' => $sales->id,
                    'product_id' => $productData['id'],
                    'net_unit_cost' => $netUnitCost,
                    'stock' => $product->product_qty + $productData['quantity'],
                    'quantity' => $productData['quantity'],
                    'discount' => $productData['discount'] ?? 0,
                    'subtotal' => $subtotal, 
                ]);

                $product->decrement('product_qty', $productData['quantity']); 
            }

            $sales->update(['grand_total' => ($grandTotal - $request->discount) + $request->tax_amount + $request->shipping]);
            $sales->total_amount = $sales->grand_total; // Helper for service

            // ✅ Record Journal Entry
            $this->financialService->recordSaleEntry($sales);

            DB::commit();

            $notification = array(
                'message' => 'Sales Stored Successfully',
                'alert-type' => 'success'
            ); 
            return redirect()->route('all.sale')->with($notification);  

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        } 
    }
    // End Method

    public function EditSales($id){
        $editData = Sale::with('saleItems.product')->findOrFail($id);
        $customers = Customer::all();
        $warehouses = WareHouse::all();
        return view('admin.backend.sales.edit_sales',compact('editData','customers','warehouses'));
    }
    // End Method 

    public function UpdateSales(Request $request, $id){

        $request->validate([
            'date' => 'required|date',
            'status' => 'required', 
        ]);

        $sales = Sale::findOrFail($id);
        $sales->update([
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
            'paid_amount' => $request->paid_amount,
            'due_amount' => $request->due_amount,
            'full_paid' => $request->full_paid,   
        ]);

        // Delete old sales item
        SaleItem::where('sale_id',$sales->id)->delete();

        foreach($request->products as $product_id => $product){
            SaleItem::create([
                'sale_id' => $sales->id,
                'product_id' => $product_id,
                'net_unit_cost' => $product['net_unit_cost'],
                'stock' => $product['stock'],
                'quantity' => $product['quantity'],
                'discount' => $product['discount'] ?? 0,
                'subtotal' => $product['subtotal'],  
            ]);

            /// Update Product Stock

            $productModel = Product::find($product_id);
            if ($productModel) {
                $productModel->product_qty += $product['quantity'];
                $productModel->save();
            }  
        }

        $notification = array(
            'message' => 'Sale Updated Successfully',
            'alert-type' => 'success'
        ); 
        return redirect()->route('all.sale')->with($notification);  
    }
    // End Method 

    public function DeleteSales($id){
        try {
          DB::beginTransaction();
          $sales = Sale::findOrFail($id);
          $SalesItems = SaleItem::where('sale_id',$id)->get();

          foreach($SalesItems as $item){
            $product = Product::find($item->product_id);
            if ($product) {
                $product->increment('product_qty',$item->quantity);
            }
          }
          SaleItem::where('sale_id',$id)->delete();
          $sales->delete();
          DB::commit();

          $notification = array(
            'message' => 'Sale Deleted Successfully',
            'alert-type' => 'success'
         ); 
         return redirect()->route('all.sale')->with($notification);  
            
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
          }  
    }
    // End Method

    public function DetailsSales($id){
        try {
            $sales = Sale::with(['customer','saleItems.product'])->find($id);

            if (!$sales) {
                return redirect()->back()->with('error', 'Sales record not found!');
            }

            return view('admin.backend.sales.sales_details', compact('sales'));

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }
    // End Method 


    public function InvoiceSales($id){
        try {
            $sales = Sale::with(['customer','warehouse','saleItems.product'])->find($id);

            if (!$sales) {
                return redirect()->back()->with('error', 'Sales record not found!');
            }

            $pdf = Pdf::loadView('admin.backend.sales.invoice_pdf', compact('sales'));
            return $pdf->download('sales_'.$id.'.pdf');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }
    // End Method 
}