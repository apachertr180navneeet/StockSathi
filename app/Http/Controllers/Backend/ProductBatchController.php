<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductBatch;
use App\Models\Product;
use Carbon\Carbon;

class ProductBatchController extends Controller
{
    public function AllBatch()
    {
        $allData = ProductBatch::with('product')->latest()->get();
        return view('admin.backend.batch.all_batch', compact('allData'));
    }

    public function AddBatch()
    {
        $products = Product::all();
        return view('admin.backend.batch.add_batch', compact('products'));
    }

    public function StoreBatch(Request $request)
    {
        $request->validate([
            'product_id' => 'required',
            'batch_no' => 'required',
            'qty' => 'required|numeric|min:0',
        ]);

        ProductBatch::insert([
            'product_id' => $request->product_id,
            'batch_no' => $request->batch_no,
            'expiry_date' => $request->expiry_date,
            'qty' => $request->qty,
            'created_at' => Carbon::now(),
        ]);

        // Optional: Update product total qty if needed, 
        // but usually batches are just part of the total.
        // For simplicity, we assume product_qty in Product table is the sum of batches + unbatched.
        // If the user wants strict batch management, we should sync it.
        $product = Product::find($request->product_id);
        $product->increment('product_qty', $request->qty);

        $notification = array(
            'message' => 'Product Batch Created Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.batch')->with($notification);
    }

    public function EditBatch($id)
    {
        $batch = ProductBatch::findOrFail($id);
        $products = Product::all();
        return view('admin.backend.batch.edit_batch', compact('batch', 'products'));
    }

    public function UpdateBatch(Request $request)
    {
        $batch_id = $request->id;
        $old_batch = ProductBatch::findOrFail($batch_id);
        $qty_diff = $request->qty - $old_batch->qty;

        $old_batch->update([
            'product_id' => $request->product_id,
            'batch_no' => $request->batch_no,
            'expiry_date' => $request->expiry_date,
            'qty' => $request->qty,
            'updated_at' => Carbon::now(),
        ]);

        // Update product total qty
        $product = Product::find($request->product_id);
        if ($qty_diff > 0) {
            $product->increment('product_qty', $qty_diff);
        } elseif ($qty_diff < 0) {
            $product->decrement('product_qty', abs($qty_diff));
        }

        $notification = array(
            'message' => 'Product Batch Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.batch')->with($notification);
    }

    public function DeleteBatch($id)
    {
        $batch = ProductBatch::findOrFail($id);
        
        // Decrement product total qty
        $product = Product::find($batch->product_id);
        $product->decrement('product_qty', $batch->qty);

        $batch->delete();

        $notification = array(
            'message' => 'Product Batch Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }
}
