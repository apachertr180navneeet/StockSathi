<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductCategory;
use App\Models\Product; 
use App\Models\Supplier; 
use App\Models\WareHouse;
use App\Models\Purchase; 
use App\Models\PurchaseItem; 
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;


class PurchaseController extends Controller
{
    // ===============================
    // Show All Purchases
    // ===============================
    public function AllPurchase(){
        $allData = Purchase::latest()->get();
        return view('admin.backend.purchase.all_purchase', compact('allData')); 
    }

    // ===============================
    // Add Purchase Page
    // ===============================
    public function AddPurchase(){
        $suppliers = Supplier::all();
        $warehouses = WareHouse::all();
        return view('admin.backend.purchase.add_purchase', compact('suppliers','warehouses'));
    }

    // ===============================
    // Product Search (AJAX)
    // ===============================
    public function PurchaseProductSearch(Request $request){
        try {

            $query = $request->input('query');
            $warehouse_id = $request->input('warehouse_id');

            $products = Product::where(function($q) use ($query){
                    $q->where('name', 'like', "%{$query}%")
                      ->orWhere('code', 'like', "%{$query}%");
                })
                ->when($warehouse_id, function ($q) use ($warehouse_id){
                    $q->where('warehouse_id', $warehouse_id);
                })
                ->select('id','name','code','price','product_qty')
                ->limit(10)
                ->get();

            return response()->json($products);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Something went wrong while searching products.'
            ], 500);
        }
    }

    // ===============================
    // Store Purchase
    // ===============================
    public function StorePurchase(Request $request){

        // ✅ Validation
        $request->validate([
            'date'        => 'required|date',
            'status'      => 'required',
            'supplier_id' => 'required',
            'products'    => 'required|array|min:1',
        ],[
            'date.required'        => 'Purchase date is required',
            'supplier_id.required' => 'Supplier is required',
            'products.required'    => 'Please add at least one product',
        ]);

        try {

            DB::beginTransaction();

            $grandTotal = 0;

            // ✅ Create Purchase
            $purchase = Purchase::create([
                'date'         => $request->date,
                'warehouse_id' => $request->warehouse_id,
                'supplier_id'  => $request->supplier_id,
                'discount'     => $request->discount ?? 0,
                'shipping'     => $request->shipping ?? 0,
                'status'       => $request->status,
                'note'         => $request->note,
                'grand_total'  => 0,
            ]);

            // ✅ Store Items
            foreach($request->products as $productData){

                $product = Product::findOrFail($productData['id']);

                $netUnitCost = $productData['net_unit_cost'] ?? $product->price;

                if (!$netUnitCost) {
                    throw new \Exception("Net Unit Cost missing for product ID: " . $productData['id']);
                }

                $qty      = $productData['quantity'];
                $discount = $productData['discount'] ?? 0;

                $subtotal = ($netUnitCost * $qty) - $discount;

                $grandTotal += $subtotal;

                // ✅ Save Purchase Item
                PurchaseItem::create([
                    'purchase_id'   => $purchase->id,
                    'product_id'    => $product->id,
                    'net_unit_cost' => $netUnitCost,
                    'stock'         => $product->product_qty + $qty,
                    'quantity'      => $qty,
                    'discount'      => $discount,
                    'subtotal'      => $subtotal,
                ]);

                // ✅ Update Stock
                $product->increment('product_qty', $qty);
            }

            // ✅ Final Total Update
            $purchase->update([
                'grand_total' => $grandTotal + ($request->shipping ?? 0) - ($request->discount ?? 0)
            ]);

            DB::commit();

            return redirect()->route('all.purchase')->with([
                'message' => 'Purchase Stored Successfully',
                'alert-type' => 'success'
            ]);

        } catch (\Exception $e) {

            DB::rollBack();

            return redirect()->back()
                ->withInput()
                ->with([
                    'message' => 'Error: '.$e->getMessage(),
                    'alert-type' => 'error'
                ]);
        }
    }

    public function EditPurchase($id){
        $editData = Purchase::with('purchaseItems.product')->findOrFail($id);
        $suppliers = Supplier::all();
        $warehouses = WareHouse::all();

        return view('admin.backend.purchase.edit_purchase', compact('editData','suppliers','warehouses'));
    }
    // End Method 


    public function UpdatePurchase(Request $request, $id)
    {
        // ✅ Validation
        $request->validate([
            'date' => 'required|date',
            'status' => 'required',
            'supplier_id' => 'required',
            'products' => 'required|array',
        ]);

        DB::beginTransaction();

        try {

            // ✅ Find Purchase
            $purchase = Purchase::findOrFail($id);

            // ✅ Update Purchase
            $purchase->update([
                'date' => $request->date,
                'warehouse_id' => $request->warehouse_id,
                'supplier_id' => $request->supplier_id,
                'discount' => $request->discount ?? 0,
                'shipping' => $request->shipping ?? 0,
                'status' => $request->status,
                'note' => $request->note,
                'grand_total' => $request->grand_total,
            ]);

            // ✅ Get Old Items
            $oldPurchaseItems = PurchaseItem::where('purchase_id', $purchase->id)->get();

            // ✅ Decrease Old Stock
            foreach ($oldPurchaseItems as $oldItem) {
                $product = Product::find($oldItem->product_id);
                if ($product) {
                    $product->decrement('product_qty', $oldItem->quantity);
                }
            }

            // ✅ Delete Old Items
            PurchaseItem::where('purchase_id', $purchase->id)->delete();

            // ✅ Insert New Items + Update Stock
            foreach ($request->products as $product_id => $productData) {

                // Skip empty rows (important)
                if (empty($productData['quantity'])) {
                    continue;
                }

                PurchaseItem::create([
                    'purchase_id' => $purchase->id,
                    'product_id' => $product_id,
                    'net_unit_cost' => $productData['net_unit_cost'] ?? 0,
                    'stock' => $productData['stock'] ?? 0,
                    'quantity' => $productData['quantity'],
                    'discount' => $productData['discount'] ?? 0,
                    'subtotal' => $productData['subtotal'] ?? 0,
                ]);

                // ✅ Increase New Stock
                $product = Product::find($product_id);
                if ($product) {
                    $product->increment('product_qty', $productData['quantity']);
                }
            }

            DB::commit();

            return redirect()->route('all.purchase')->with([
                'message' => 'Purchase Updated Successfully',
                'alert-type' => 'success'
            ]);

        } catch (\Exception $e) {

            DB::rollBack();

            // ✅ Redirect with error (better for UI)
            return redirect()->back()->withInput()->with([
                'message' => 'Something went wrong: ' . $e->getMessage(),
                'alert-type' => 'error'
            ]);
        }
    }
    // End Method

    public function DetailsPurchase($id)
    {
        try {
            $purchase = Purchase::with(['supplier', 'purchaseItems.product'])->findOrFail($id);

            return view('admin.backend.purchase.purchase_details', compact('purchase'));

        } catch (\Exception $e) {

            // Optional: Log error
            \Log::error('Purchase Details Error: ' . $e->getMessage());

            // Redirect back with error message
            return redirect()->back()->with('error', 'Something went wrong while fetching purchase details.');
        }
    }
    // End Method

    public function InvoicePurchase($id)
    {
        try {
            // Fetch purchase with relations
            $purchase = Purchase::with(['supplier', 'warehouse', 'purchaseItems.product'])->findOrFail($id);

            // Generate PDF
            $pdf = Pdf::loadView('admin.backend.purchase.invoice_pdf', compact('purchase'));

            // Download PDF
            return $pdf->download('purchase_' . $id . '.pdf');

        } catch (\Exception $e) {

            // Optional: log error
            \Log::error('Invoice Purchase Error: ' . $e->getMessage());

            // Redirect back with error message
            return redirect()->back()->with([
                'message' => 'Something went wrong while generating invoice!',
                'alert-type' => 'error'
            ]);
        }
    }
    // End Method

    public function DeletePurchase($id){
        try {
          DB::beginTransaction();
          $purchase = Purchase::findOrFail($id);
          $purchaseItems = PurchaseItem::where('purchase_id',$id)->get();

          foreach($purchaseItems as $item){
            $product = Product::find($item->product_id);
            if ($product) {
                $product->decrement('product_qty',$item->quantity);
            }
          }
          PurchaseItem::where('purchase_id',$id)->delete();
          $purchase->delete();
          DB::commit();

          $notification = array(
            'message' => 'Purchase Deleted Successfully',
            'alert-type' => 'success'
         ); 
         return redirect()->route('all.purchase')->with($notification);  
            
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
          }  
    }
    // End Method 
}