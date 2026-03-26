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
}