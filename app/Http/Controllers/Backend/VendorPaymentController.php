<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Supplier;
use App\Models\Purchase;
use App\Models\VendorPayment;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class VendorPaymentController extends Controller
{
    /**
     * Display all vendor payments
     */
    public function AllVendorPayment()
    {
        $allData = VendorPayment::with(['supplier', 'purchase'])->latest()->get();
        return view('admin.backend.payment.all_vendor_payment', compact('allData'));
    }

    /**
     * Show form to add payment
     */
    public function AddVendorPayment($purchase_id = null)
    {
        $suppliers = Supplier::all();
        $purchases = Purchase::where('payment_status', '!=', 'Paid')->get();
        $selected_purchase = null;
        
        if ($purchase_id) {
            $selected_purchase = Purchase::with('supplier')->findOrFail($purchase_id);
        }
        
        return view('admin.backend.payment.add_vendor_payment', compact('suppliers', 'purchases', 'selected_purchase'));
    }

    /**
     * Store a new vendor payment
     */
    public function StoreVendorPayment(Request $request)
    {
        $request->validate([
            'supplier_id' => 'required',
            'amount' => 'required|numeric|min:1',
            'payment_date' => 'required|date',
            'payment_method' => 'required',
        ], [
            'supplier_id.required' => 'Please select a supplier',
            'amount.min' => 'Amount must be greater than 0',
        ]);

        DB::beginTransaction();

        try {
            // Generate payment number
            $lastPayment = VendorPayment::latest('id')->first();
            $payment_no = 'PAY-' . str_pad(($lastPayment ? $lastPayment->id + 1 : 1), 6, '0', STR_PAD_LEFT);

            $payment = VendorPayment::create([
                'payment_no' => $payment_no,
                'supplier_id' => $request->supplier_id,
                'purchase_id' => $request->purchase_id,
                'amount' => $request->amount,
                'payment_date' => $request->payment_date,
                'payment_method' => $request->payment_method,
                'reference_no' => $request->reference_no,
                'note' => $request->note,
            ]);

            // If linked to a purchase, update purchase totals
            if ($request->purchase_id) {
                $purchase = Purchase::findOrFail($request->purchase_id);
                $purchase->paid_amount += $request->amount;
                $purchase->due_amount = $purchase->grand_total - $purchase->paid_amount;

                if ($purchase->due_amount <= 0) {
                    $purchase->payment_status = 'Paid';
                } elseif ($purchase->paid_amount > 0) {
                    $purchase->payment_status = 'Partial';
                } else {
                    $purchase->payment_status = 'Pending';
                }
                $purchase->save();
            }

            DB::commit();

            return redirect()->route('all.vendor.payment')->with([
                'message' => 'Vendor Payment Recorded Successfully',
                'alert-type' => 'success'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with([
                'message' => 'Error: ' . $e->getMessage(),
                'alert-type' => 'error'
            ]);
        }
    }

    /**
     * Delete a vendor payment
     */
    public function DeleteVendorPayment($id)
    {
        DB::beginTransaction();
        try {
            $payment = VendorPayment::findOrFail($id);

            // Revert purchase totals if linked
            if ($payment->purchase_id) {
                $purchase = Purchase::findOrFail($payment->purchase_id);
                $purchase->paid_amount -= $payment->amount;
                $purchase->due_amount = $purchase->grand_total - $purchase->paid_amount;

                if ($purchase->due_amount <= 0) {
                    $purchase->payment_status = 'Paid';
                } elseif ($purchase->paid_amount > 0) {
                    $purchase->payment_status = 'Partial';
                } else {
                    $purchase->payment_status = 'Pending';
                }
                $purchase->save();
            }

            $payment->delete();
            DB::commit();

            return redirect()->back()->with([
                'message' => 'Vendor Payment Deleted Successfully',
                'alert-type' => 'success'
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with([
                'message' => 'Error: ' . $e->getMessage(),
                'alert-type' => 'error'
            ]);
        }
    }
}
