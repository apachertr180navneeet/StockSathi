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
    /**
     * ===============================
     * Display All Purchases
     * ===============================
     */
    public function AllPurchase()
    {
        // Get latest purchases
        $allData = Purchase::latest()->get();

        return view('admin.backend.purchase.all_purchase', compact('allData'));
    }

    /**
     * ===============================
     * Show Add Purchase Page
     * ===============================
     */
    public function AddPurchase()
    {
        return view('admin.backend.purchase.add_purchase', [
            'suppliers'  => Supplier::all(),
            'warehouses' => WareHouse::all(),
        ]);
    }

    /**
     * ===============================
     * AJAX Product Search
     * ===============================
     */
    public function PurchaseProductSearch(Request $request)
    {
        try {
            $query        = $request->input('query');
            $warehouse_id = $request->input('warehouse_id');
            $supplier_id  = $request->input('supplier_id'); // ✅ NEW

            $products = Product::query()

                // 🔍 Search by name or code
                ->when($query, function ($q) use ($query) {
                    $q->where(function ($sub) use ($query) {
                        $sub->where('name', 'like', "%{$query}%")
                            ->orWhere('code', 'like', "%{$query}%");
                    });
                })

                // 🏬 Filter by warehouse
                ->when($warehouse_id, function ($q) use ($warehouse_id) {
                    $q->where('warehouse_id', $warehouse_id);
                })

                // 🧑‍💼 Filter by supplier (NEW)
                ->when($supplier_id, function ($q) use ($supplier_id) {
                    $q->where('supplier_id', $supplier_id);
                })

                ->select('id', 'name', 'code', 'price', 'product_qty')
                ->limit(10)
                ->get();

            return response()->json($products);

        } catch (\Exception $e) {
            return response()->json([
                'error'   => 'Product search failed!',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * ===============================
     * Store Purchase
     * ===============================
     */
    public function StorePurchase(Request $request)
    {
        // Validate request
        $request->validate([
            'date'        => 'required|date',
            'status'      => 'required',
            'supplier_id' => 'required',
            'products'    => 'required|array|min:1',
        ]);

        DB::beginTransaction();

        try {
            $grandTotal = 0;

            // Create Purchase
            $purchase = Purchase::create([
                'date'         => $request->date,
                'warehouse_id' => $request->warehouse_id,
                'supplier_id'  => $request->supplier_id,
                'discount'     => $request->discount ?? 0,
                'shipping'     => $request->shipping ?? 0,
                'status'       => $request->status,
                'note'         => $request->note,
                'grand_total'  => 0, // will update later
            ]);

            // Loop through products
            foreach ($request->products as $productData) {

                $product = Product::findOrFail($productData['id']);

                $netUnitCost = $productData['net_unit_cost'] ?? $product->price;
                $qty         = $productData['quantity'];
                $discount    = $productData['discount'] ?? 0;

                // Validate cost
                if (!$netUnitCost) {
                    throw new \Exception("Missing cost for product ID: {$product->id}");
                }

                // Calculate subtotal
                $subtotal = ($netUnitCost * $qty) - $discount;
                $grandTotal += $subtotal;

                // Save item
                PurchaseItem::create([
                    'purchase_id'   => $purchase->id,
                    'product_id'    => $product->id,
                    'net_unit_cost' => $netUnitCost,
                    'stock'         => $product->product_qty + $qty,
                    'quantity'      => $qty,
                    'discount'      => $discount,
                    'subtotal'      => $subtotal,
                ]);

                // Update stock
                $product->increment('product_qty', $qty);
            }

            // Update final total
            $grandTotalFinal = $grandTotal + ($request->shipping ?? 0) - ($request->discount ?? 0);
            $purchase->update([
                'grand_total' => $grandTotalFinal,
                'due_amount' => $grandTotalFinal,
                'payment_status' => 'Pending',
            ]);

            DB::commit();

            return redirect()->route('all.purchase')->with([
                'message' => 'Purchase Created Successfully',
                'alert-type' => 'success'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            return back()->withInput()->with([
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            ]);
        }
    }

    /**
     * ===============================
     * Edit Purchase
     * ===============================
     */
    public function EditPurchase($id)
    {
        $editData = Purchase::with('purchaseItems.product')->findOrFail($id);

        return view('admin.backend.purchase.edit_purchase', [
            'editData'   => $editData,
            'suppliers'  => Supplier::all(),
            'warehouses' => WareHouse::all(),
        ]);
    }

    /**
     * ===============================
     * Update Purchase
     * ===============================
     */
    public function UpdatePurchase(Request $request, $id)
    {
        $request->validate([
            'date'        => 'required|date',
            'status'      => 'required',
            'supplier_id' => 'required',
            'products'    => 'required|array',
        ]);

        DB::beginTransaction();

        try {
            $purchase = Purchase::findOrFail($id);

            // Update main purchase
            $purchase->update([
                'date'         => $request->date,
                'warehouse_id' => $request->warehouse_id,
                'supplier_id'  => $request->supplier_id,
                'discount'     => $request->discount ?? 0,
                'shipping'     => $request->shipping ?? 0,
                'status'       => $request->status,
                'note'         => $request->note,
                'grand_total'  => $request->grand_total,
                'due_amount'   => $request->grand_total - $purchase->paid_amount,
            ]);

            // Update payment status based on new grand total
            if ($purchase->due_amount <= 0) {
                $purchase->payment_status = 'Paid';
            } elseif ($purchase->paid_amount > 0) {
                $purchase->payment_status = 'Partial';
            } else {
                $purchase->payment_status = 'Pending';
            }
            $purchase->save();

            // Reverse old stock
            foreach ($purchase->purchaseItems as $item) {
                optional($item->product)->decrement('product_qty', $item->quantity);
            }

            // Delete old items
            $purchase->purchaseItems()->delete();

            // Insert new items
            foreach ($request->products as $product_id => $data) {

                if (empty($data['quantity'])) continue;

                PurchaseItem::create([
                    'purchase_id'   => $purchase->id,
                    'product_id'    => $product_id,
                    'net_unit_cost' => $data['net_unit_cost'] ?? 0,
                    'stock'         => $data['stock'] ?? 0,
                    'quantity'      => $data['quantity'],
                    'discount'      => $data['discount'] ?? 0,
                    'subtotal'      => $data['subtotal'] ?? 0,
                ]);

                // Update stock
                optional(Product::find($product_id))
                    ->increment('product_qty', $data['quantity']);
            }

            DB::commit();

            return redirect()->route('all.purchase')->with([
                'message' => 'Purchase Updated Successfully',
                'alert-type' => 'success'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            return back()->withInput()->with([
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            ]);
        }
    }

    /**
     * ===============================
     * Purchase Details
     * ===============================
     */
    public function DetailsPurchase($id)
    {
        try {
            $purchase = Purchase::with(['supplier', 'purchaseItems.product'])->findOrFail($id);

            return view('admin.backend.purchase.purchase_details', compact('purchase'));

        } catch (\Exception $e) {
            \Log::error('Purchase Details Error: ' . $e->getMessage());

            return back()->with('error', 'Unable to load purchase details.');
        }
    }

    /**
     * ===============================
     * Generate Invoice PDF
     * ===============================
     */
    public function InvoicePurchase($id)
    {
        try {
            $purchase = Purchase::with(['supplier', 'warehouse', 'purchaseItems.product'])->findOrFail($id);

            $pdf = Pdf::loadView('admin.backend.purchase.invoice_pdf', compact('purchase'));

            return $pdf->download("purchase_{$id}.pdf");

        } catch (\Exception $e) {
            \Log::error('Invoice Error: ' . $e->getMessage());

            return back()->with([
                'message' => 'Invoice generation failed!',
                'alert-type' => 'error'
            ]);
        }
    }

    /**
     * ===============================
     * Delete Purchase
     * ===============================
     */
    public function DeletePurchase($id)
    {
        DB::beginTransaction();

        try {
            $purchase = Purchase::findOrFail($id);

            // Reverse stock
            foreach ($purchase->purchaseItems as $item) {
                optional($item->product)->decrement('product_qty', $item->quantity);
            }

            // Delete items & purchase
            $purchase->purchaseItems()->delete();
            $purchase->delete();

            DB::commit();

            return redirect()->route('all.purchase')->with([
                'message' => 'Purchase Deleted Successfully',
                'alert-type' => 'success'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }
}