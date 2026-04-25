<?php

namespace App\Services;

use App\Models\Account;
use App\Models\JournalEntry;
use App\Models\JournalItem;
use Illuminate\Support\Facades\DB;
use Exception;

class FinancialService
{
    /**
     * Create a general journal entry.
     */
    public function createJournalEntry($entryData, $items)
    {
        return DB::transaction(function () use ($entryData, $items) {
            // Validate balance
            $totalDebit = collect($items)->sum('debit');
            $totalCredit = collect($items)->sum('credit');

            if (number_format($totalDebit, 2) !== number_format($totalCredit, 2)) {
                throw new Exception("Journal entry does not balance. Debits: $totalDebit, Credits: $totalCredit");
            }

            $entry = JournalEntry::create($entryData);

            foreach ($items as $item) {
                $entry->items()->create($item);
            }

            return $entry;
        });
    }

    /**
     * Get system account by code.
     */
    protected function getAccountByCode($code)
    {
        $account = Account::where('code', $code)->first();
        if (!$account) {
            throw new Exception("System account with code $code not found. Please run AccountSeeder.");
        }
        return $account;
    }

    /**
     * Record a Sale transaction.
     */
    public function recordSaleEntry($sale)
    {
        $cashAccount = $this->getAccountByCode('1000');
        $receivableAccount = $this->getAccountByCode('1020');
        $salesAccount = $this->getAccountByCode('4000');
        $taxAccount = $this->getAccountByCode('2010');
        $inventoryAccount = $this->getAccountByCode('1030');
        $cogsAccount = $this->getAccountByCode('5000');

        $entryData = [
            'entry_date' => $sale->sale_date ?? now(),
            'reference_no' => 'SALE-' . $sale->id . '-' . time(),
            'description' => 'Sale Transaction #' . ($sale->invoice_no ?? $sale->id),
            'source_type' => 'Sale',
            'source_id' => $sale->id,
            'created_by' => auth()->id(),
        ];

        $items = [];

        // 1. Debit Cash or Accounts Receivable
        $paymentMethod = $sale->payment_method ?? 'Cash';
        $mainDebitAccount = ($paymentMethod === 'Cash') ? $cashAccount : $receivableAccount;
        
        $items[] = [
            'account_id' => $mainDebitAccount->id,
            'debit' => $sale->total_amount,
            'credit' => 0,
            'description' => 'Sale Payment (' . $paymentMethod . ')',
        ];

        // 2. Credit Sales Revenue (Excluding Tax)
        $taxAmount = $sale->tax_amount ?? 0;
        $netSales = $sale->total_amount - $taxAmount;

        $items[] = [
            'account_id' => $salesAccount->id,
            'debit' => 0,
            'credit' => $netSales,
            'description' => 'Sales Revenue',
        ];

        // 3. Credit Tax Payable
        if ($taxAmount > 0) {
            $items[] = [
                'account_id' => $taxAccount->id,
                'debit' => 0,
                'credit' => $taxAmount,
                'description' => 'Tax Collected',
            ];
        }

        // Note: Inventory/COGS logic would need cost prices which might not be in the sale record directly.
        // Usually handled during sale if unit cost is known.

        return $this->createJournalEntry($entryData, $items);
    }

    /**
     * Record a Purchase transaction.
     */
    public function recordPurchaseEntry($purchase)
    {
        $inventoryAccount = $this->getAccountByCode('1030');
        $payableAccount = $this->getAccountByCode('2000');
        $taxAccount = $this->getAccountByCode('2010');

        $entryData = [
            'entry_date' => $purchase->purchase_date ?? now(),
            'reference_no' => 'PUR-' . $purchase->id . '-' . time(),
            'description' => 'Purchase Transaction #' . ($purchase->purchase_no ?? $purchase->id),
            'source_type' => 'Purchase',
            'source_id' => $purchase->id,
            'created_by' => auth()->id(),
        ];

        $items = [];

        // 1. Debit Inventory (Excluding Tax)
        $taxAmount = $purchase->tax_amount ?? 0;
        $netInventory = $purchase->total_amount - $taxAmount;

        $items[] = [
            'account_id' => $inventoryAccount->id,
            'debit' => $netInventory,
            'credit' => 0,
            'description' => 'Inventory Purchase',
        ];

        // 2. Debit Tax (Input Tax Credit)
        if ($taxAmount > 0) {
            $items[] = [
                'account_id' => $taxAccount->id,
                'debit' => $taxAmount,
                'credit' => 0,
                'description' => 'Tax Paid on Purchase',
            ];
        }

        // 3. Credit Accounts Payable
        $items[] = [
            'account_id' => $payableAccount->id,
            'debit' => 0,
            'credit' => $purchase->total_amount,
            'description' => 'Purchase Payable',
        ];

        return $this->createJournalEntry($entryData, $items);
    }
}
