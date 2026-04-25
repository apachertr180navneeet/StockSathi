<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionMasterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            // 1. DASHBOARD
            ['name' => 'dashboard.view', 'group_name' => 'dashboard'],

            // 2. INVENTORY
            ['name' => 'brand.all', 'group_name' => 'brand'],
            ['name' => 'brand.add', 'group_name' => 'brand'],
            ['name' => 'brand.edit', 'group_name' => 'brand'],
            ['name' => 'brand.delete', 'group_name' => 'brand'],

            ['name' => 'warehouse.all', 'group_name' => 'warehouse'],
            ['name' => 'warehouse.add', 'group_name' => 'warehouse'],
            ['name' => 'warehouse.edit', 'group_name' => 'warehouse'],
            ['name' => 'warehouse.delete', 'group_name' => 'warehouse'],

            ['name' => 'category.all', 'group_name' => 'category'],
            ['name' => 'category.add', 'group_name' => 'category'],
            ['name' => 'category.edit', 'group_name' => 'category'],
            ['name' => 'category.delete', 'group_name' => 'category'],

            ['name' => 'product.all', 'group_name' => 'product'],
            ['name' => 'product.add', 'group_name' => 'product'],
            ['name' => 'product.edit', 'group_name' => 'product'],
            ['name' => 'product.delete', 'group_name' => 'product'],
            ['name' => 'product.details', 'group_name' => 'product'],

            ['name' => 'stock.adjustment.all', 'group_name' => 'stock_adjustment'],
            ['name' => 'stock.adjustment.add', 'group_name' => 'stock_adjustment'],
            ['name' => 'stock.adjustment.delete', 'group_name' => 'stock_adjustment'],

            ['name' => 'batch.all', 'group_name' => 'batch'],
            ['name' => 'batch.add', 'group_name' => 'batch'],
            ['name' => 'batch.edit', 'group_name' => 'batch'],
            ['name' => 'batch.delete', 'group_name' => 'batch'],

            ['name' => 'bin.rack.all', 'group_name' => 'bin_rack'],
            ['name' => 'bin.rack.add', 'group_name' => 'bin_rack'],
            ['name' => 'bin.rack.edit', 'group_name' => 'bin_rack'],
            ['name' => 'bin.rack.delete', 'group_name' => 'bin_rack'],

            // 3. CONTACTS
            ['name' => 'supplier.all', 'group_name' => 'supplier'],
            ['name' => 'supplier.add', 'group_name' => 'supplier'],
            ['name' => 'supplier.edit', 'group_name' => 'supplier'],
            ['name' => 'supplier.delete', 'group_name' => 'supplier'],

            ['name' => 'customer.all', 'group_name' => 'customer'],
            ['name' => 'customer.add', 'group_name' => 'customer'],
            ['name' => 'customer.edit', 'group_name' => 'customer'],
            ['name' => 'customer.delete', 'group_name' => 'customer'],

            // 4. PURCHASE
            ['name' => 'purchase.requisition.all', 'group_name' => 'purchase'],
            ['name' => 'purchase.requisition.add', 'group_name' => 'purchase'],
            ['name' => 'purchase.order.all', 'group_name' => 'purchase'],
            ['name' => 'purchase.order.add', 'group_name' => 'purchase'],
            ['name' => 'purchase.all', 'group_name' => 'purchase'],
            ['name' => 'purchase.add', 'group_name' => 'purchase'],
            ['name' => 'purchase.edit', 'group_name' => 'purchase'],
            ['name' => 'purchase.delete', 'group_name' => 'purchase'],
            ['name' => 'purchase.invoice', 'group_name' => 'purchase'],
            ['name' => 'vendor.payment.all', 'group_name' => 'purchase'],
            ['name' => 'purchase.return.all', 'group_name' => 'purchase'],

            // 5. SALES
            ['name' => 'sales.order.all', 'group_name' => 'sale'],
            ['name' => 'sales.order.add', 'group_name' => 'sale'],
            ['name' => 'quotation.all', 'group_name' => 'sale'],
            ['name' => 'quotation.add', 'group_name' => 'sale'],
            ['name' => 'sale.all', 'group_name' => 'sale'],
            ['name' => 'sale.add', 'group_name' => 'sale'],
            ['name' => 'sale.edit', 'group_name' => 'sale'],
            ['name' => 'sale.delete', 'group_name' => 'sale'],
            ['name' => 'sale.invoice', 'group_name' => 'sale'],
            ['name' => 'sale.return.all', 'group_name' => 'sale'],
            ['name' => 'pos.all', 'group_name' => 'sale'],
            ['name' => 'delivery.all', 'group_name' => 'sale'],

            // 6. LOGISTICS
            ['name' => 'transfer.all', 'group_name' => 'transfer'],
            ['name' => 'transfer.add', 'group_name' => 'transfer'],
            ['name' => 'transfer.edit', 'group_name' => 'transfer'],
            ['name' => 'transfer.delete', 'group_name' => 'transfer'],

            // 7. ACCOUNTING
            ['name' => 'account.all', 'group_name' => 'accounting'],
            ['name' => 'account.add', 'group_name' => 'accounting'],
            ['name' => 'tax.all', 'group_name' => 'accounting'],
            ['name' => 'expense.all', 'group_name' => 'accounting'],
            ['name' => 'expense.add', 'group_name' => 'accounting'],
            ['name' => 'financial.report.all', 'group_name' => 'accounting'],

            // 8. HR MANAGEMENT
            ['name' => 'hr.menu', 'group_name' => 'hr'],
            ['name' => 'department.all', 'group_name' => 'hr'],
            ['name' => 'department.add', 'group_name' => 'hr'],
            ['name' => 'department.edit', 'group_name' => 'hr'],
            ['name' => 'department.delete', 'group_name' => 'hr'],
            ['name' => 'designation.all', 'group_name' => 'hr'],
            ['name' => 'designation.add', 'group_name' => 'hr'],
            ['name' => 'designation.edit', 'group_name' => 'hr'],
            ['name' => 'designation.delete', 'group_name' => 'hr'],
            ['name' => 'employee.all', 'group_name' => 'hr'],
            ['name' => 'employee.add', 'group_name' => 'hr'],
            ['name' => 'employee.edit', 'group_name' => 'hr'],
            ['name' => 'employee.delete', 'group_name' => 'hr'],
            ['name' => 'employee.details', 'group_name' => 'hr'],
            ['name' => 'attendance.all', 'group_name' => 'hr'],
            ['name' => 'attendance.add', 'group_name' => 'hr'],
            ['name' => 'attendance.delete', 'group_name' => 'hr'],
            ['name' => 'payroll.all', 'group_name' => 'hr'],
            ['name' => 'payroll.add', 'group_name' => 'hr'],
            ['name' => 'payroll.details', 'group_name' => 'hr'],
            ['name' => 'payroll.delete', 'group_name' => 'hr'],

            // 9. ROLE & PERMISSION
            ['name' => 'permission.all', 'group_name' => 'role'],
            ['name' => 'permission.add', 'group_name' => 'role'],
            ['name' => 'permission.edit', 'group_name' => 'role'],
            ['name' => 'permission.delete', 'group_name' => 'role'],
            ['name' => 'role.all', 'group_name' => 'role'],
            ['name' => 'role.add', 'group_name' => 'role'],
            ['name' => 'role.edit', 'group_name' => 'role'],
            ['name' => 'role.delete', 'group_name' => 'role'],
            ['name' => 'role.permission.all', 'group_name' => 'role'],

            // 10. ADMIN MANAGE
            ['name' => 'admin.all', 'group_name' => 'admin'],
            ['name' => 'admin.add', 'group_name' => 'admin'],
            ['name' => 'admin.edit', 'group_name' => 'admin'],
            ['name' => 'admin.delete', 'group_name' => 'admin'],
        ];

        foreach ($permissions as $item) {
            Permission::updateOrCreate(
                ['name' => $item['name']],
                ['group_name' => $item['group_name']]
            );
        }

        // Assign all permissions to Admin role
        $adminRole = Role::updateOrCreate(['name' => 'Admin']);
        $allPermissions = Permission::all();
        $adminRole->syncPermissions($allPermissions);
    }
}
