<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Customer;
use App\Models\WareHouse;
use App\Models\ProductCategory;
use App\Models\Sale;
use App\Models\SaleItem;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PosController extends Controller
{
    public function PosIndex()
    {
        $customers = Customer::latest()->get();
        $warehouses = WareHouse::latest()->get();
        $categories = ProductCategory::latest()->get();
        
        // Initial load of products
        $products = Product::with(['category', 'brand'])
            ->where('product_qty', '>', 0)
            ->latest()
            ->limit(24)
            ->get();

        return view('admin.backend.pos.pos_index', compact('customers', 'warehouses', 'categories', 'products'));
    }

    public function GetProducts(Request $request)
    {
        $query = Product::with(['category', 'brand'])->where('product_qty', '>', 0);

        if ($request->category_id) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%");
            });
        }

        $products = $query->latest()->limit(50)->get();

        return view('admin.backend.pos.pos_product_grid', compact('products'))->render();
    }

    public function StorePos(Request $request)
    {
        $request->validate([
            'customer_id' => 'required',
            'warehouse_id' => 'required',
            'products' => 'required|array',
            'payment_method' => 'required'
        ]);

        DB::beginTransaction();

        try {
            $sale = new Sale();
            $sale->date = date('Y-m-d');
            $sale->warehouse_id = $request->warehouse_id;
            $sale->customer_id = $request->customer_id;
            $sale->discount = $request->discount ?? 0;
            $sale->tax_rate = $request->tax_rate ?? 0;
            $sale->tax_amount = $request->tax_amount ?? 0;
            $sale->shipping = $request->shipping ?? 0;
            $sale->grand_total = $request->grand_total;
            $sale->paid_amount = $request->paid_amount ?? 0;
            $sale->due_amount = $request->due_amount ?? 0;
            $sale->payment_method = $request->payment_method;
            
            // Set status based on due amount
            if ($sale->due_amount > 0) {
                $sale->status = 'Pending';
            } else {
                $sale->status = 'Sale';
            }

            $sale->note = $request->note;
            $sale->save();

            // Insert Sale Items and deduct stock
            foreach ($request->products as $productId => $item) {
                $saleItem = new SaleItem();
                $saleItem->sale_id = $sale->id;
                $saleItem->product_id = $productId;
                $saleItem->quantity = $item['quantity'];
                $saleItem->net_unit_cost = $item['net_unit_cost'];
                $saleItem->discount = $item['discount'] ?? 0;
                $saleItem->tax_rate = $item['tax_rate'] ?? 0;
                $saleItem->tax = $item['tax'] ?? 0;
                $saleItem->subtotal = $item['subtotal'];
                $saleItem->save();

                // Deduct stock
                $product = Product::find($productId);
                if ($product) {
                    $product->product_qty -= $item['quantity'];
                    $product->save();
                }
            }

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Sale completed successfully.',
                'sale_id' => $sale->id,
                'redirect_url' => route('pos.receipt', $sale->id)
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function PosReceipt($id)
    {
        $sale = Sale::with(['customer', 'warehouse', 'saleItems.product'])->findOrFail($id);
        return view('admin.backend.pos.pos_receipt', compact('sale'));
    }
}
