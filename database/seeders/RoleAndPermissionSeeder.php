<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create Permissions
        $permissions = [
            ['name' => 'brand.all', 'group_name' => 'brand'],
            ['name' => 'brand.add', 'group_name' => 'brand'],
            ['name' => 'brand.edit', 'group_name' => 'brand'],
            ['name' => 'brand.delete', 'group_name' => 'brand'],

            ['name' => 'warehouse.all', 'group_name' => 'warehouse'],
            ['name' => 'warehouse.add', 'group_name' => 'warehouse'],
            ['name' => 'warehouse.edit', 'group_name' => 'warehouse'],
            ['name' => 'warehouse.delete', 'group_name' => 'warehouse'],

            ['name' => 'supplier.all', 'group_name' => 'supplier'],
            ['name' => 'supplier.add', 'group_name' => 'supplier'],
            ['name' => 'supplier.edit', 'group_name' => 'supplier'],
            ['name' => 'supplier.delete', 'group_name' => 'supplier'],

            ['name' => 'customer.all', 'group_name' => 'customer'],
            ['name' => 'customer.add', 'group_name' => 'customer'],
            ['name' => 'customer.edit', 'group_name' => 'customer'],
            ['name' => 'customer.delete', 'group_name' => 'customer'],

            ['name' => 'product.all', 'group_name' => 'product'],
            ['name' => 'product.add', 'group_name' => 'product'],
            ['name' => 'product.edit', 'group_name' => 'product'],
            ['name' => 'product.delete', 'group_name' => 'product'],

            ['name' => 'purchase.all', 'group_name' => 'purchase'],
            ['name' => 'purchase.add', 'group_name' => 'purchase'],
            ['name' => 'purchase.edit', 'group_name' => 'purchase'],
            ['name' => 'purchase.delete', 'group_name' => 'purchase'],

            ['name' => 'sale.all', 'group_name' => 'sale'],
            ['name' => 'sale.add', 'group_name' => 'sale'],
            ['name' => 'sale.edit', 'group_name' => 'sale'],
            ['name' => 'sale.delete', 'group_name' => 'sale'],

            ['name' => 'transfer.all', 'group_name' => 'transfer'],
            ['name' => 'transfer.add', 'group_name' => 'transfer'],
            ['name' => 'transfer.edit', 'group_name' => 'transfer'],
            ['name' => 'transfer.delete', 'group_name' => 'transfer'],

            ['name' => 'report.all', 'group_name' => 'report'],
            ['name' => 'role.permission.all', 'group_name' => 'role'],
        ];

        foreach ($permissions as $permission) {
            Permission::updateOrCreate(['name' => $permission['name']], $permission);
        }

        // Create Roles and assign existing permissions
        $adminRole = Role::firstOrCreate(['name' => 'Admin']);
        $adminRole->givePermissionTo(Permission::all());

        $managerRole = Role::firstOrCreate(['name' => 'Manager']);
        $managerRole->givePermissionTo([
            'brand.all', 'warehouse.all', 'supplier.all', 'customer.all', 'product.all',
            'purchase.all', 'sale.all', 'transfer.all', 'report.all'
        ]);

        $staffRole = Role::firstOrCreate(['name' => 'Staff']);
        $staffRole->givePermissionTo([
            'sale.all', 'sale.add', 'product.all'
        ]);

        // Assign Admin role to the main admin user
        $adminUser = User::where('email', 'admin@stocksathi.com')->first();
        if ($adminUser) {
            $adminUser->assignRole($adminRole);
        }
    }
}
