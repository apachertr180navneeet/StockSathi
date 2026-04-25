<?php

use App\Models\Sale;
use App\Models\Account;
use App\Models\JournalEntry;
use App\Models\JournalItem;
use App\Services\FinancialService;
use Illuminate\Support\Facades\DB;

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "Starting Accounting Test...\n";

DB::beginTransaction();

try {
    $service = new FinancialService();

    // 1. Check if accounts exist
    $cash = Account::where('code', '1000')->first();
    if (!$cash) {
        echo "Error: Cash account not found. Run seeder.\n";
        exit;
    }

    echo "Initial Cash Balance: " . $cash->current_balance . "\n";

    // 2. Mock a Sale
    $sale = new Sale();
    $sale->id = 999;
    $sale->invoice_no = 'TEST-001';
    $sale->total_amount = 1000;
    $sale->tax_amount = 100;
    $sale->payment_method = 'Cash';
    $sale->sale_date = now();

    echo "Recording Sale of 1000 (Tax: 100)...\n";
    $service->recordSaleEntry($sale);

    // 3. Verify Balances
    $cash->refresh();
    echo "New Cash Balance: " . $cash->current_balance . " (Expected: 1000 if initial was 0)\n";

    $salesRevenue = Account::where('code', '4000')->first();
    echo "Sales Revenue Balance: " . $salesRevenue->current_balance . " (Expected: 900)\n";

    $taxPayable = Account::where('code', '2010')->first();
    echo "Tax Payable Balance: " . $taxPayable->current_balance . " (Expected: 100)\n";

    // 4. Verify Journal Entry
    $entry = JournalEntry::where('source_type', 'Sale')->where('source_id', 999)->first();
    if ($entry) {
        echo "Journal Entry Created: " . $entry->reference_no . "\n";
        foreach ($entry->items as $item) {
            echo "  Item: " . $item->account->name . " | Debit: " . $item->debit . " | Credit: " . $item->credit . "\n";
        }
    } else {
        echo "Error: Journal Entry NOT created!\n";
    }

    DB::rollBack();
    echo "Test Finished (Rolled back).\n";

} catch (Exception $e) {
    DB::rollBack();
    echo "Error: " . $e->getMessage() . "\n";
}
