<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tax;
use App\Models\Account;
use Exception;

class TaxController extends Controller
{
    /**
     * Display all taxes
     */
    public function AllTax(Request $request)
    {
        try {
            $query = Tax::with('account');

            if ($request->search) {
                $query->where('name', 'like', '%' . $request->search . '%');
            }

            $taxes = $query->orderBy('name', 'asc')->get();

            if ($request->ajax()) {
                return view('admin.backend.tax.partials.tax_table', compact('taxes'))->render();
            }
            return view('admin.backend.tax.all_tax', compact('taxes'));
        } catch (Exception $e) {
            return back()->with([
                'message' => 'Something went wrong!',
                'alert-type' => 'error'
            ]);
        }
    }

    /**
     * Show add tax form
     */
    public function AddTax()
    {
        $accounts = Account::whereIn('type', ['Liability', 'Expense'])->orderBy('name', 'asc')->get();
        return view('admin.backend.tax.add_tax', compact('accounts'));
    }

    /**
     * Store tax
     */
    public function StoreTax(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'rate' => 'required|numeric|min:0',
            'type' => 'required|in:Percentage,Fixed',
            'account_id' => 'nullable|exists:accounts,id',
        ]);

        try {
            Tax::create([
                'name' => $request->name,
                'rate' => $request->rate,
                'type' => $request->type,
                'account_id' => $request->account_id,
                'status' => 'Active',
            ]);

            return redirect()->route('all.tax')->with([
                'message' => 'Tax Created Successfully',
                'alert-type' => 'success'
            ]);
        } catch (Exception $e) {
            return back()->withInput()->with([
                'message' => 'Something went wrong!',
                'alert-type' => 'error'
            ]);
        }
    }

    /**
     * Edit tax
     */
    public function EditTax($id)
    {
        try {
            $tax = Tax::findOrFail($id);
            $accounts = Account::whereIn('type', ['Liability', 'Expense'])->orderBy('name', 'asc')->get();
            return view('admin.backend.tax.edit_tax', compact('tax', 'accounts'));
        } catch (Exception $e) {
            return back()->with([
                'message' => 'Tax not found!',
                'alert-type' => 'error'
            ]);
        }
    }

    /**
     * Update tax
     */
    public function UpdateTax(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:taxes,id',
            'name' => 'required|string|max:100',
            'rate' => 'required|numeric|min:0',
            'type' => 'required|in:Percentage,Fixed',
            'account_id' => 'nullable|exists:accounts,id',
        ]);

        try {
            $tax = Tax::findOrFail($request->id);
            $tax->update([
                'name' => $request->name,
                'rate' => $request->rate,
                'type' => $request->type,
                'account_id' => $request->account_id,
                'status' => $request->status ?? 'Active',
            ]);

            return redirect()->route('all.tax')->with([
                'message' => 'Tax Updated Successfully',
                'alert-type' => 'success'
            ]);
        } catch (Exception $e) {
            return back()->withInput()->with([
                'message' => 'Something went wrong!',
                'alert-type' => 'error'
            ]);
        }
    }

    /**
     * Delete tax
     */
    public function DeleteTax($id)
    {
        try {
            $tax = Tax::findOrFail($id);
            $tax->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Tax Deleted Successfully'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }
}
