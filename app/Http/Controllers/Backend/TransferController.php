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
use App\Models\Transfer; 
use App\Models\TransferItem; 

class TransferController extends Controller
{
    // ================= All Transfer =================
    public function AllTransfer(){
        try {
            $allData = Transfer::with(['transferItems.product'])
                        ->orderBy('id','desc')
                        ->get();

            return view('admin.backend.transfer.all_transfer',compact('allData'));

        } catch (\Exception $e) {
            return back()->with([
                'message' => 'Error loading transfers: '.$e->getMessage(),
                'alert-type' => 'error'
            ]);
        }
    }
    // End Method 


    // ================= Add Transfer =================
    public function AddTransfer(){
        try {
            $warehouses = WareHouse::all();
            return view('admin.backend.transfer.add_transfer',compact('warehouses'));

        } catch (\Exception $e) {
            return back()->with([
                'message' => 'Error loading warehouses: '.$e->getMessage(),
                'alert-type' => 'error'
            ]);
        }
    }
    // End Method 


    // ================= Store Transfer =================
    public function StoreTransfer(Request $request){

        $request->validate([
            'date' => 'required|date',
            'status' => 'required',
            'from_warehouse_id' => 'required',
            'to_warehouse_id' => 'required',
            'products' => 'required|array|min:1',
        ]);

        try {

            DB::beginTransaction(); 

            $transfer = Transfer::create([
                'date' => $request->date,
                'from_warehouse_id' => $request->from_warehouse_id,
                'to_warehouse_id' => $request->to_warehouse_id,
                'discount' => $request->discount ?? 0,
                'shipping' => $request->shipping ?? 0,
                'status' => $request->status,
                'note' => $request->note,
                'grand_total' => 0, 
            ]);

            $grandTotal = 0;

            foreach($request->products as $productData){

                $product = Product::findOrFail($productData['id']);

                $netUnitCost = $product->price; 
                $quantity = $productData['quantity'];
                $discount = $productData['discount'] ?? 0;

                // ❗ Prevent negative stock
                if ($product->product_qty < $quantity) {
                    throw new \Exception("Insufficient stock for product: ".$product->name);
                }

                $subtotal = ($netUnitCost * $quantity) - $discount; 
                $grandTotal += $subtotal;

                TransferItem::create([
                    'transfer_id' => $transfer->id,
                    'product_id' => $productData['id'],
                    'net_unit_cost' => $netUnitCost,
                    'stock' => $product->product_qty,
                    'quantity' => $quantity,
                    'discount' => $discount,
                    'subtotal' => $subtotal, 
                ]);

                // ===== Decrease stock from source warehouse =====
                Product::where('id',$productData['id'])
                    ->where('warehouse_id', $request->from_warehouse_id)
                    ->decrement('product_qty',$quantity);

                // ===== Check destination warehouse =====
                $existingProduct = Product::where('name',$product->name)
                    ->where('brand_id', $product->brand_id)
                    ->where('warehouse_id', $request->to_warehouse_id)
                    ->first();

                if ($existingProduct) {
                    $existingProduct->increment('product_qty',$quantity);
                } else {
                    Product::create([
                        'name' => $product->name,
                        'brand_id' => $product->brand_id,
                        'warehouse_id' => $request->to_warehouse_id,
                        'price' => $product->price,
                        'product_qty' => $quantity,
                        'status' => 1,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }

            // ===== Update Grand Total =====
            $transfer->update([
                'grand_total' => $grandTotal
            ]);

            DB::commit();

            return redirect()->route('all.transfer')->with([
                'message' => 'Transfer Complete Successfully',
                'alert-type' => 'success'
            ]);

        } catch (\Exception $e) {

            DB::rollBack();

            return back()->with([
                'message' => 'Transfer Failed: '.$e->getMessage(),
                'alert-type' => 'error'
            ]);
        }
    }
    // End Method

    // ================= Edit Transfer =================
    public function EditTransfer($id){
        try {
            $editData = Transfer::with(['fromWarehouse','toWarehouse','transferItems.product'])->findOrFail($id);
            $warehouses = WareHouse::all();

            return view('admin.backend.transfer.edit_transfer',compact('warehouses','editData')); 

        } catch (\Exception $e) {
            return back()->with([
                'message' => 'Error loading transfer: '.$e->getMessage(),
                'alert-type' => 'error'
            ]);
        }
    }
    // End Method 



    // ================= Update Transfer =================
    public function UpdateTransfer(Request $request, $id){

        $request->validate([
            'date' => 'required|date',
            'status' => 'required',
            'products' => 'required|array|min:1',
        ]);

        try {

            DB::beginTransaction();

            $transfer = Transfer::findOrFail($id);

            // ================= RESTORE OLD STOCK =================
            $oldTransferItems = TransferItem::where('transfer_id', $transfer->id)->get();

            foreach($oldTransferItems as $oldItem){

                // Return stock to FROM warehouse
                Product::where('id',$oldItem->product_id)
                    ->where('warehouse_id',$transfer->from_warehouse_id)
                    ->increment('product_qty',$oldItem->quantity);

                // Remove stock from TO warehouse
                Product::where('id',$oldItem->product_id)
                    ->where('warehouse_id',$transfer->to_warehouse_id)
                    ->decrement('product_qty',$oldItem->quantity);
            }

            // ❗ Delete old items OUTSIDE loop (IMPORTANT FIX)
            TransferItem::where('transfer_id',$transfer->id)->delete();


            // ================= UPDATE TRANSFER =================
            $transfer->update([
                'date' => $request->date, 
                'discount' => $request->discount ?? 0,
                'shipping' => $request->shipping ?? 0,
                'status' => $request->status,
                'note' => $request->note,
            ]);


            // ================= ADD NEW ITEMS =================
            $grandTotal = 0;

            foreach($request->products as $productId => $productData){

                $product = Product::findOrFail($productId);

                $quantity = $productData['quantity'];
                $discount = $productData['discount'] ?? 0;
                $price = $product->price ?? 0;

                // ❗ Stock check
                if ($product->product_qty < $quantity) {
                    throw new \Exception("Insufficient stock for product: ".$product->name);
                }

                $subtotal = ($price * $quantity) - $discount;
                $grandTotal += $subtotal;

                TransferItem::create([
                    'transfer_id' => $transfer->id,
                    'product_id' => $productId,
                    'net_unit_cost' => $price,
                    'stock' => $product->product_qty,
                    'quantity' => $quantity,
                    'discount' => $discount,
                    'subtotal' => $subtotal,
                ]);

                // FROM warehouse decrease
                Product::where('id',$productId)
                    ->where('warehouse_id',$transfer->from_warehouse_id)
                    ->decrement('product_qty',$quantity);

                // TO warehouse increase
                Product::where('id',$productId)
                    ->where('warehouse_id',$transfer->to_warehouse_id)
                    ->increment('product_qty',$quantity);
            }

            // ================= UPDATE TOTAL =================
            $transfer->update([
                'grand_total' => $grandTotal
            ]);

            DB::commit();

            return redirect()->route('all.transfer')->with([
                'message' => 'Transfer Updated Successfully',
                'alert-type' => 'success'
            ]);  

        } catch (\Exception $e) {

            DB::rollBack();

            return back()->with([
                'message' => 'Transfer Update Failed: '.$e->getMessage(),
                'alert-type' => 'error'
            ]);
        }
    }
    // End Method 



    // ================= Delete Transfer =================
    public function DeleteTransfer($id){

        try {

            DB::beginTransaction();

            $transfer = Transfer::findOrFail($id);
            $transferItems = TransferItem::where('transfer_id',$transfer->id)->get();

            foreach($transferItems as $item){

                // Return stock to FROM warehouse
                Product::where('id',$item->product_id)
                    ->where('warehouse_id',$transfer->from_warehouse_id)
                    ->increment('product_qty',$item->quantity);

                // Remove stock from TO warehouse
                Product::where('id',$item->product_id)
                    ->where('warehouse_id',$transfer->to_warehouse_id)
                    ->decrement('product_qty',$item->quantity);
            }

            TransferItem::where('transfer_id',$transfer->id)->delete();
            $transfer->delete();

            DB::commit();

            return redirect()->route('all.transfer')->with([
                'message' => 'Transfer Deleted Successfully',
                'alert-type' => 'success'
            ]);  

        } catch (\Exception $e) {

            DB::rollBack();

            return back()->with([
                'message' => 'Transfer Delete Failed: '.$e->getMessage(),
                'alert-type' => 'error'
            ]);
        }  
    }
    // End Method


    public function DetailsTransfer($id){
        try {

            $transfer = Transfer::with(['transferItems.product'])->findOrFail($id);

            // ❗ No single product in transfer (multiple items exist)
            // So we don't fetch Product separately

            $fromWarehouse = WareHouse::findOrFail($transfer->from_warehouse_id);
            $toWarehouse   = WareHouse::findOrFail($transfer->to_warehouse_id);

            return view('admin.backend.transfer.details_transfer', compact(
                'transfer',
                'fromWarehouse',
                'toWarehouse'
            ));

        } catch (\Exception $e) {

            return back()->with([
                'message' => 'Error loading transfer details: '.$e->getMessage(),
                'alert-type' => 'error'
            ]);
        }
    }
    // End Method

}