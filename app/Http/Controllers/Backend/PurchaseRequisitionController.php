<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Product; 
use App\Models\Supplier; 
use App\Models\WareHouse;
use App\Models\PurchaseRequisition; 
use App\Models\PurchaseRequisitionItem;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class PurchaseRequisitionController extends Controller
{
    public function AllRequisition()
    {
        $allData = PurchaseRequisition::latest()->get();
        return view('admin.backend.purchase_requisition.all_requisition', compact('allData'));
    }

    public function AddRequisition()
    {
        $suppliers = Supplier::all();
        $warehouses = WareHouse::all();
        return view('admin.backend.purchase_requisition.add_requisition', compact('suppliers', 'warehouses'));
    }

    public function StoreRequisition(Request $request)
    {
        $request->validate([
            'date' => 'required',
            'products' => 'required|array',
        ]);

        DB::beginTransaction();
        try {
            // Generate Requisition No
            $lastReq = PurchaseRequisition::latest()->first();
            $reqNo = $lastReq ? 'REQ-' . str_pad((int)substr($lastReq->requisition_no, 4) + 1, 5, '0', STR_PAD_LEFT) : 'REQ-00001';

            $requisition = PurchaseRequisition::create([
                'requisition_no' => $reqNo,
                'date' => $request->date,
                'supplier_id' => $request->supplier_id,
                'warehouse_id' => $request->warehouse_id,
                'total_amount' => $request->total_amount,
                'status' => 'Pending',
                'note' => $request->note,
                'created_by' => Auth::id(),
                'created_at' => Carbon::now(),
            ]);

            foreach ($request->products as $product_id => $data) {
                if ($data['quantity'] > 0) {
                    PurchaseRequisitionItem::create([
                        'requisition_id' => $requisition->id,
                        'product_id' => $product_id,
                        'quantity' => $data['quantity'],
                        'estimated_cost' => $data['unit_cost'] ?? 0,
                        'subtotal' => $data['subtotal'] ?? 0,
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('all.purchase.requisition')->with([
                'message' => 'Purchase Requisition Created Successfully',
                'alert-type' => 'success'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with([
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            ]);
        }
    }

    public function EditRequisition($id)
    {
        $editData = PurchaseRequisition::with('requisitionItems.product')->findOrFail($id);
        $suppliers = Supplier::all();
        $warehouses = WareHouse::all();
        return view('admin.backend.purchase_requisition.edit_requisition', compact('editData', 'suppliers', 'warehouses'));
    }

    public function UpdateRequisition(Request $request, $id)
    {
        $request->validate([
            'date' => 'required',
            'products' => 'required|array',
        ]);

        DB::beginTransaction();
        try {
            $requisition = PurchaseRequisition::findOrFail($id);
            $requisition->update([
                'date' => $request->date,
                'supplier_id' => $request->supplier_id,
                'warehouse_id' => $request->warehouse_id,
                'total_amount' => $request->total_amount,
                'status' => $request->status,
                'note' => $request->note,
                'updated_by' => Auth::id(),
                'updated_at' => Carbon::now(),
            ]);

            $requisition->requisitionItems()->delete();

            foreach ($request->products as $product_id => $data) {
                if ($data['quantity'] > 0) {
                    PurchaseRequisitionItem::create([
                        'requisition_id' => $requisition->id,
                        'product_id' => $product_id,
                        'quantity' => $data['quantity'],
                        'estimated_cost' => $data['unit_cost'] ?? 0,
                        'subtotal' => $data['subtotal'] ?? 0,
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('all.purchase.requisition')->with([
                'message' => 'Purchase Requisition Updated Successfully',
                'alert-type' => 'success'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with([
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            ]);
        }
    }

    public function DetailsRequisition($id)
    {
        $requisition = PurchaseRequisition::with(['requisitionItems.product', 'supplier', 'warehouse'])->findOrFail($id);
        return view('admin.backend.purchase_requisition.details_requisition', compact('requisition'));
    }

    public function InvoiceRequisition($id)
    {
        $requisition = PurchaseRequisition::with(['requisitionItems.product', 'supplier', 'warehouse'])->findOrFail($id);
        $pdf = Pdf::loadView('admin.backend.purchase_requisition.invoice_pdf', compact('requisition'));
        return $pdf->download('requisition-'.$requisition->requisition_no.'.pdf');
    }

    public function DeleteRequisition($id)
    {
        $requisition = PurchaseRequisition::findOrFail($id);
        $requisition->requisitionItems()->delete();
        $requisition->delete();

        return redirect()->back()->with([
            'message' => 'Purchase Requisition Deleted Successfully',
            'alert-type' => 'success'
        ]);
    }

    public function ConvertToPurchase($id)
    {
        DB::beginTransaction();
        try {
            $requisition = PurchaseRequisition::with('requisitionItems')->findOrFail($id);

            if ($requisition->status != 'Approved') {
                return redirect()->back()->with([
                    'message' => 'Only Approved requisitions can be converted to Purchase.',
                    'alert-type' => 'warning'
                ]);
            }

            // Create Purchase
            $purchase = Purchase::create([
                'date' => Carbon::now()->format('Y-m-d'),
                'warehouse_id' => $requisition->warehouse_id,
                'supplier_id' => $requisition->supplier_id,
                'grand_total' => $requisition->total_amount,
                'status' => 'Pending',
                'note' => 'Generated from Requisition: ' . $requisition->requisition_no,
                'created_at' => Carbon::now(),
            ]);

            // Copy Items
            foreach ($requisition->requisitionItems as $item) {
                PurchaseItem::create([
                    'purchase_id' => $purchase->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'net_unit_cost' => $item->estimated_cost,
                    'subtotal' => $item->subtotal,
                ]);

                // Note: We don't update stock here as the Purchase status is 'Pending'.
                // If the system updates stock on Purchase creation, we should do it here too.
                // Looking at PurchaseController@StorePurchase, it DOES update stock immediately.
                
                $product = Product::find($item->product_id);
                if ($product) {
                    $product->increment('product_qty', $item->quantity);
                }
            }

            // Update Requisition Status
            $requisition->update(['status' => 'Completed']);

            DB::commit();
            return redirect()->route('all.purchase')->with([
                'message' => 'Requisition converted to Purchase successfully.',
                'alert-type' => 'success'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with([
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            ]);
        }
    }
}
