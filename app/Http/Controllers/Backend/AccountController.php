<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Account;
use Exception;

class AccountController extends Controller
{
    /**
     * Display Chart of Accounts
     */
    public function AllAccount(Request $request)
    {
        try {
            $query = Account::query();

            if ($request->search) {
                $query->where(function($q) use ($request) {
                    $q->where('name', 'like', '%' . $request->search . '%')
                      ->orWhere('code', 'like', '%' . $request->search . '%');
                });
            }

            if ($request->type) {
                $query->where('type', $request->type);
            }

            $accounts = $query->orderBy('code', 'asc')->get();

            if ($request->ajax()) {
                return view('admin.backend.account.partials.account_table', compact('accounts'))->render();
            }
            return view('admin.backend.account.all_account', compact('accounts'));
        } catch (Exception $e) {
            return back()->with([
                'message' => 'Something went wrong!',
                'alert-type' => 'error'
            ]);
        }
    }

    /**
     * Show add account form
     */
    public function AddAccount()
    {
        $parentAccounts = Account::orderBy('code', 'asc')->get();
        return view('admin.backend.account.add_account', compact('parentAccounts'));
    }

    /**
     * Store account
     */
    public function StoreAccount(Request $request)
    {
        $request->validate([
            'code' => 'required|unique:accounts,code',
            'name' => 'required|string|max:255',
            'type' => 'required|in:Asset,Liability,Equity,Revenue,Expense',
            'opening_balance' => 'nullable|numeric',
        ]);

        try {
            Account::create([
                'code' => $request->code,
                'name' => $request->name,
                'type' => $request->type,
                'parent_id' => $request->parent_id,
                'description' => $request->description,
                'opening_balance' => $request->opening_balance ?? 0,
                'current_balance' => $request->opening_balance ?? 0,
            ]);

            return redirect()->route('all.account')->with([
                'message' => 'Account Created Successfully',
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
     * Edit account
     */
    public function EditAccount($id)
    {
        try {
            $account = Account::findOrFail($id);
            $parentAccounts = Account::where('id', '!=', $id)->orderBy('code', 'asc')->get();
            return view('admin.backend.account.edit_account', compact('account', 'parentAccounts'));
        } catch (Exception $e) {
            return back()->with([
                'message' => 'Account not found!',
                'alert-type' => 'error'
            ]);
        }
    }

    /**
     * Update account
     */
    public function UpdateAccount(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:accounts,id',
            'code' => 'required|unique:accounts,code,' . $request->id,
            'name' => 'required|string|max:255',
            'type' => 'required|in:Asset,Liability,Equity,Revenue,Expense',
        ]);

        try {
            $account = Account::findOrFail($request->id);
            
            if ($account->is_system && $account->code != $request->code) {
                return back()->with([
                    'message' => 'System account code cannot be changed!',
                    'alert-type' => 'warning'
                ]);
            }

            $account->update([
                'code' => $request->code,
                'name' => $request->name,
                'type' => $request->type,
                'parent_id' => $request->parent_id,
                'description' => $request->description,
                'status' => $request->status ?? 'Active',
            ]);

            return redirect()->route('all.account')->with([
                'message' => 'Account Updated Successfully',
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
     * Delete account
     */
    public function DeleteAccount($id)
    {
        try {
            $account = Account::findOrFail($id);

            if ($account->is_system) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'System accounts cannot be deleted!'
                ]);
            }

            if ($account->journalItems()->exists()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Account has transactions and cannot be deleted!'
                ]);
            }

            $account->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Account Deleted Successfully'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }
}
