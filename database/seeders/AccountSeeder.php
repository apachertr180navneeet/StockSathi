<?php

namespace Database\Seeders;

use App\Models\Account;
use Illuminate\Database\Seeder;

class AccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $accounts = [
            // ASSETS (1000)
            ['code' => '1000', 'name' => 'Cash', 'type' => 'Asset', 'is_system' => true],
            ['code' => '1010', 'name' => 'Bank', 'type' => 'Asset', 'is_system' => true],
            ['code' => '1020', 'name' => 'Accounts Receivable', 'type' => 'Asset', 'is_system' => true],
            ['code' => '1030', 'name' => 'Inventory', 'type' => 'Asset', 'is_system' => true],
            
            // LIABILITIES (2000)
            ['code' => '2000', 'name' => 'Accounts Payable', 'type' => 'Liability', 'is_system' => true],
            ['code' => '2010', 'name' => 'Tax Payable', 'type' => 'Liability', 'is_system' => true],
            
            // EQUITY (3000)
            ['code' => '3000', 'name' => 'Owner\'s Equity', 'type' => 'Equity', 'is_system' => true],
            ['code' => '3010', 'name' => 'Retained Earnings', 'type' => 'Equity', 'is_system' => true],
            
            // REVENUE (4000)
            ['code' => '4000', 'name' => 'Sales Revenue', 'type' => 'Revenue', 'is_system' => true],
            ['code' => '4010', 'name' => 'Other Income', 'type' => 'Revenue', 'is_system' => true],
            
            // EXPENSES (5000)
            ['code' => '5000', 'name' => 'Cost of Goods Sold', 'type' => 'Expense', 'is_system' => true],
            ['code' => '5010', 'name' => 'Rent Expense', 'type' => 'Expense', 'is_system' => false],
            ['code' => '5020', 'name' => 'Salary Expense', 'type' => 'Expense', 'is_system' => false],
            ['code' => '5030', 'name' => 'Utility Expense', 'type' => 'Expense', 'is_system' => false],
            ['code' => '5040', 'name' => 'Marketing Expense', 'type' => 'Expense', 'is_system' => false],
        ];

        foreach ($accounts as $account) {
            Account::updateOrCreate(['code' => $account['code']], $account);
        }
    }
}
