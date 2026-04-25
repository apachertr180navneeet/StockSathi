<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StockAdjustment;
use App\Models\StockAdjustmentItem;
use App\Models\Product;
use App\Models\WareHouse;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class StockAdjustmentController extends Controller
{
    public function AllStockAdjustment()
    {
        $allData = StockAdjustment::with('warehouse')->latest()->get();
        return view('admin.backend.stock_adjustment.all_adjustment', compact('allData'));
    }

    public function AddStockAdjustment()
    {
        $warehouses = WareHouse::all();
        $products = Product::all();
        return view('admin.backend.stock_adjustment.add_adjustment', compact('warehouses', 'products'));
    }

    public function StoreStockAdjustment(Request $request)
    {
        $request->validate([
            'warehouse_id' => 'required',
            'date' => 'required',
            'type' => 'required',
            'product_id' => 'required|array',
            'qty' => 'required|array',
        ]);

        DB::beginTransaction();
        try {
            $adjustment = StockAdjustment::create([
                'reference_no' => 'ADJ-' . time(),
                'warehouse_id' => $request->warehouse_id,
                'date' => $request->date,
                'type' => $request->type,
                'reason' => $request->reason,
                'created_by' => Auth::id(),
                'created_at' => Carbon::now(),
            ]);

            foreach ($request->product_id as $key => $product_id) {
                StockAdjustmentItem::create([
                    'stock_adjustment_id' => $adjustment->id,
                    'product_id' => $product_id,
                    'qty' => $request->qty[$key],
                ]);

                // Update Product Stock
                $product = Product::findOrFail($product_id);
                if ($request->type == 'Addition') {
                    $product->increment('product_qty', $request->qty[$key]);
                } else {
                    $product->decrement('product_qty', $request->qty[$key]);
                }
            }

            DB::commit();

            $notification = array(
                'message' => 'Stock Adjustment Created Successfully',
                'alert-type' => 'success'
            );

            return redirect()->route('all.stock.adjustment')->with($notification);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with([
                'message' => 'Something went wrong: ' . $e->getMessage(),
                'alert-type' => 'error'
            ]);
        }
    }

    public function DetailsStockAdjustment($id)
    {
        $adjustment = StockAdjustment::with('warehouse', 'items.product')->findOrFail($id);
        return view('admin.backend.stock_adjustment.details_adjustment', compact('adjustment'));
    }

    public function DeleteStockAdjustment($id)
    {
        DB::beginTransaction();
        try {
            $adjustment = StockAdjustment::findOrFail($id);
            
            // Reverse stock changes
            foreach ($adjustment->items as $item) {
                $product = Product::findOrFail($item->product_id);
                if ($adjustment->type == 'Addition') {
                    $product->decrement('product_qty', $item->qty);
                } else {
                    $product->increment('product_qty', $item->qty);
                }
            }

            $adjustment->delete();
            DB::commit();

            $notification = array(
                'message' => 'Stock Adjustment Deleted and Stock Reversed',
                'alert-type' => 'success'
            );

            return redirect()->back()->with($notification);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with([
                'message' => 'Delete failed: ' . $e->getMessage(),
                'alert-type' => 'error'
            ]);
        }
    }
}
