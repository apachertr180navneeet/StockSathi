<?php

use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\WareHouse;
use App\Models\PurchaseRequisition;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class PurchaseOrderController extends Controller
{
    public function AllPurchaseOrder()
    {
        $allData = PurchaseOrder::with(['supplier', 'warehouse'])->latest()->get();
        return view('admin.backend.purchase_order.all_purchase_order', compact('allData'));
    }

    public function AddPurchaseOrder()
    {
        $suppliers = Supplier::all();
        $warehouses = WareHouse::all();
        return view('admin.backend.purchase_order.add_purchase_order', compact('suppliers', 'warehouses'));
    }

    public function StorePurchaseOrder(Request $request)
    {
        $request->validate([
            'date' => 'required',
            'supplier_id' => 'required',
            'warehouse_id' => 'required',
            'products' => 'required|array',
        ]);

        DB::beginTransaction();
        try {
            // Generate PO No
            $lastPo = PurchaseOrder::latest()->first();
            $poNo = $lastPo ? 'PO-' . str_pad((int)substr($lastPo->po_no, 3) + 1, 5, '0', STR_PAD_LEFT) : 'PO-00001';

            $purchaseOrder = PurchaseOrder::create([
                'po_no' => $poNo,
                'date' => $request->date,
                'supplier_id' => $request->supplier_id,
                'warehouse_id' => $request->warehouse_id,
                'requisition_id' => $request->requisition_id,
                'tax_rate' => $request->tax_rate ?? 0,
                'tax_amount' => $request->tax_amount ?? 0,
                'discount' => $request->discount ?? 0,
                'shipping' => $request->shipping ?? 0,
                'grand_total' => $request->grand_total,
                'status' => 'Ordered',
                'note' => $request->note,
                'created_by' => Auth::id(),
                'created_at' => Carbon::now(),
            ]);

            foreach ($request->products as $product_id => $data) {
                if ($data['quantity'] > 0) {
                    PurchaseOrderItem::create([
                        'purchase_order_id' => $purchaseOrder->id,
                        'product_id' => $product_id,
                        'quantity' => $data['quantity'],
                        'unit_cost' => $data['unit_cost'],
                        'tax_rate' => $data['tax_rate'] ?? 0,
                        'tax_amount' => $data['tax_amount'] ?? 0,
                        'discount' => $data['discount'] ?? 0,
                        'subtotal' => $data['subtotal'],
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('all.purchase.order')->with([
                'message' => 'Purchase Order Created Successfully',
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

    public function EditPurchaseOrder($id)
    {
        $editData = PurchaseOrder::with('items.product')->findOrFail($id);
        $suppliers = Supplier::all();
        $warehouses = WareHouse::all();
        return view('admin.backend.purchase_order.edit_purchase_order', compact('editData', 'suppliers', 'warehouses'));
    }

    public function UpdatePurchaseOrder(Request $request, $id)
    {
        $request->validate([
            'date' => 'required',
            'supplier_id' => 'required',
            'warehouse_id' => 'required',
            'products' => 'required|array',
        ]);

        DB::beginTransaction();
        try {
            $purchaseOrder = PurchaseOrder::findOrFail($id);
            $purchaseOrder->update([
                'date' => $request->date,
                'supplier_id' => $request->supplier_id,
                'warehouse_id' => $request->warehouse_id,
                'tax_rate' => $request->tax_rate ?? 0,
                'tax_amount' => $request->tax_amount ?? 0,
                'discount' => $request->discount ?? 0,
                'shipping' => $request->shipping ?? 0,
                'grand_total' => $request->grand_total,
                'status' => $request->status,
                'note' => $request->note,
                'updated_by' => Auth::id(),
                'updated_at' => Carbon::now(),
            ]);

            $purchaseOrder->items()->delete();

            foreach ($request->products as $product_id => $data) {
                if ($data['quantity'] > 0) {
                    PurchaseOrderItem::create([
                        'purchase_order_id' => $purchaseOrder->id,
                        'product_id' => $product_id,
                        'quantity' => $data['quantity'],
                        'unit_cost' => $data['unit_cost'],
                        'tax_rate' => $data['tax_rate'] ?? 0,
                        'tax_amount' => $data['tax_amount'] ?? 0,
                        'discount' => $data['discount'] ?? 0,
                        'subtotal' => $data['subtotal'],
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('all.purchase.order')->with([
                'message' => 'Purchase Order Updated Successfully',
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

    public function DetailsPurchaseOrder($id)
    {
        $order = PurchaseOrder::with(['items.product', 'supplier', 'warehouse', 'createdBy'])->findOrFail($id);
        return view('admin.backend.purchase_order.details_purchase_order', compact('order'));
    }

    public function InvoicePurchaseOrder($id)
    {
        $order = PurchaseOrder::with(['items.product', 'supplier', 'warehouse'])->findOrFail($id);
        $pdf = Pdf::loadView('admin.backend.purchase_order.invoice_pdf', compact('order'));
        return $pdf->download('PO-'.$order->po_no.'.pdf');
    }

    public function DeletePurchaseOrder($id)
    {
        $purchaseOrder = PurchaseOrder::findOrFail($id);
        $purchaseOrder->items()->delete();
        $purchaseOrder->delete();

        return redirect()->back()->with([
            'message' => 'Purchase Order Deleted Successfully',
            'alert-type' => 'success'
        ]);
    }

    public function ConvertFromRequisition($id)
    {
        $requisition = PurchaseRequisition::with('requisitionItems.product')->findOrFail($id);
        $suppliers = Supplier::all();
        $warehouses = WareHouse::all();
        return view('admin.backend.purchase_order.add_purchase_order', compact('requisition', 'suppliers', 'warehouses'));
    }
}
