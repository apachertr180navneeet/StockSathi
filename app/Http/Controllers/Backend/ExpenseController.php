<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Expense;
use App\Models\Account;
use App\Services\FinancialService;
use Exception;
use Illuminate\Support\Facades\DB;

class ExpenseController extends Controller
{
    protected $financialService;

    public function __construct(FinancialService $financialService)
    {
        $this->financialService = $financialService;
    }

    /**
     * Display all expenses
     */
    public function AllExpense(Request $request)
    {
        try {
            $query = Expense::with(['expenseAccount', 'paymentAccount', 'creator']);

            if ($request->search) {
                $query->where('expense_no', 'like', '%' . $request->search . '%')
                      ->orWhere('description', 'like', '%' . $request->search . '%');
            }

            $expenses = $query->orderBy('expense_date', 'desc')->paginate(10);

            if ($request->ajax()) {
                return view('admin.backend.expense.partials.expense_table', compact('expenses'))->render();
            }
            return view('admin.backend.expense.all_expense', compact('expenses'));
        } catch (Exception $e) {
            return back()->with([
                'message' => 'Something went wrong!',
                'alert-type' => 'error'
            ]);
        }
    }

    /**
     * Show add expense form
     */
    public function AddExpense()
    {
        $expenseAccounts = Account::where('type', 'Expense')->orderBy('name', 'asc')->get();
        $paymentAccounts = Account::whereIn('code', ['1000', '1010'])->orderBy('name', 'asc')->get(); // Cash or Bank
        $expenseNo = 'EXP-' . strtoupper(substr(uniqid(), -6));
        
        return view('admin.backend.expense.add_expense', compact('expenseAccounts', 'paymentAccounts', 'expenseNo'));
    }

    /**
     * Store expense
     */
    public function StoreExpense(Request $request)
    {
        $request->validate([
            'expense_no' => 'required|unique:expenses,expense_no',
            'account_id' => 'required|exists:accounts,id',
            'payment_account_id' => 'required|exists:accounts,id',
            'amount' => 'required|numeric|min:0.01',
            'expense_date' => 'required|date',
        ]);

        return DB::transaction(function () use ($request) {
            try {
                $expense = Expense::create([
                    'expense_no' => $request->expense_no,
                    'account_id' => $request->account_id,
                    'payment_account_id' => $request->payment_account_id,
                    'amount' => $request->amount,
                    'expense_date' => $request->expense_date,
                    'reference_no' => $request->reference_no,
                    'description' => $request->description,
                    'created_by' => auth()->id(),
                ]);

                // Record Journal Entry
                $expenseAccount = Account::find($request->account_id);
                $paymentAccount = Account::find($request->payment_account_id);

                $entryData = [
                    'entry_date' => $request->expense_date,
                    'reference_no' => $request->expense_no,
                    'description' => 'Expense: ' . $request->description,
                    'source_type' => 'Expense',
                    'source_id' => $expense->id,
                    'created_by' => auth()->id(),
                ];

                $items = [
                    [
                        'account_id' => $expenseAccount->id,
                        'debit' => $request->amount,
                        'credit' => 0,
                        'description' => 'Expense: ' . $expenseAccount->name,
                    ],
                    [
                        'account_id' => $paymentAccount->id,
                        'debit' => 0,
                        'credit' => $request->amount,
                        'description' => 'Payment from ' . $paymentAccount->name,
                    ]
                ];

                $this->financialService->createJournalEntry($entryData, $items);

                return redirect()->route('all.expense')->with([
                    'message' => 'Expense Recorded Successfully',
                    'alert-type' => 'success'
                ]);
            } catch (Exception $e) {
                throw $e;
            }
        });
    }

    /**
     * Delete expense
     */
    public function DeleteExpense($id)
    {
        try {
            $expense = Expense::findOrFail($id);
            // Journal entries should probably be reversed or marked as void instead of deleted.
            // For now, we'll delete the associated journal entry if it exists.
            
            DB::transaction(function () use ($expense) {
                \App\Models\JournalEntry::where('source_type', 'Expense')
                    ->where('source_id', $expense->id)
                    ->delete();
                
                $expense->delete();
            });

            return response()->json([
                'status' => 'success',
                'message' => 'Expense Deleted Successfully'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }
}
