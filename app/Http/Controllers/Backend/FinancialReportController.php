<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Account;
use App\Models\JournalItem;
use App\Models\JournalEntry;
use Exception;
use Illuminate\Support\Facades\DB;

class FinancialReportController extends Controller
{
    /**
     * Profit & Loss Report
     */
    public function ProfitLoss(Request $request)
    {
        try {
            $startDate = $request->start_date ?? now()->startOfMonth()->toDateString();
            $endDate = $request->end_date ?? now()->toDateString();

            // Revenue Accounts
            $revenueAccounts = Account::where('type', 'Revenue')->get();
            $revenueItems = JournalItem::whereHas('journalEntry', function($q) use ($startDate, $endDate) {
                $q->whereBetween('entry_date', [$startDate, $endDate]);
            })->whereIn('account_id', $revenueAccounts->pluck('id'))->get();

            $totalRevenue = $revenueItems->sum('credit') - $revenueItems->sum('debit');

            // Expense Accounts
            $expenseAccounts = Account::where('type', 'Expense')->get();
            $expenseItems = JournalItem::whereHas('journalEntry', function($q) use ($startDate, $endDate) {
                $q->whereBetween('entry_date', [$startDate, $endDate]);
            })->whereIn('account_id', $expenseAccounts->pluck('id'))->get();

            $totalExpenses = $expenseItems->sum('debit') - $expenseItems->sum('credit');

            $netProfit = $totalRevenue - $totalExpenses;

            return view('admin.backend.report.profit_loss', compact('startDate', 'endDate', 'revenueAccounts', 'expenseAccounts', 'totalRevenue', 'totalExpenses', 'netProfit', 'revenueItems', 'expenseItems'));
        } catch (Exception $e) {
            return back()->with([
                'message' => 'Something went wrong!',
                'alert-type' => 'error'
            ]);
        }
    }

    /**
     * Ledger Report for a specific account
     */
    public function LedgerReport(Request $request)
    {
        try {
            $accountId = $request->account_id;
            $startDate = $request->start_date ?? now()->startOfMonth()->toDateString();
            $endDate = $request->end_date ?? now()->toDateString();

            if (!$accountId) {
                $accounts = Account::orderBy('code', 'asc')->get();
                return view('admin.backend.report.ledger_selection', compact('accounts'));
            }

            $account = Account::findOrFail($accountId);
            
            $items = JournalItem::with('journalEntry')
                ->where('account_id', $accountId)
                ->whereHas('journalEntry', function($q) use ($startDate, $endDate) {
                    $q->whereBetween('entry_date', [$startDate, $endDate]);
                })
                ->orderBy(JournalEntry::select('entry_date')->whereColumn('journal_entries.id', 'journal_items.journal_entry_id'))
                ->get();

            // Calculate running balance
            $openingDebit = JournalItem::where('account_id', $accountId)
                ->whereHas('journalEntry', function($q) use ($startDate) {
                    $q->where('entry_date', '<', $startDate);
                })->sum('debit');

            $openingCredit = JournalItem::where('account_id', $accountId)
                ->whereHas('journalEntry', function($q) use ($startDate) {
                    $q->where('entry_date', '<', $startDate);
                })->sum('credit');

            if (in_array($account->type, ['Asset', 'Expense'])) {
                $openingBalance = $account->opening_balance + ($openingDebit - $openingCredit);
            } else {
                $openingBalance = $account->opening_balance + ($openingCredit - $openingDebit);
            }

            return view('admin.backend.report.ledger_report', compact('account', 'items', 'startDate', 'endDate', 'openingBalance'));
        } catch (Exception $e) {
            return back()->with([
                'message' => 'Something went wrong!',
                'alert-type' => 'error'
            ]);
        }
    }
}
