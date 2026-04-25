<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class HRPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            // HR Menu
            ['name' => 'hr.menu', 'group_name' => 'hr'],
            
            // Departments
            ['name' => 'department.all', 'group_name' => 'hr'],
            ['name' => 'department.add', 'group_name' => 'hr'],
            ['name' => 'department.edit', 'group_name' => 'hr'],
            ['name' => 'department.delete', 'group_name' => 'hr'],
            
            // Designations
            ['name' => 'designation.all', 'group_name' => 'hr'],
            ['name' => 'designation.add', 'group_name' => 'hr'],
            ['name' => 'designation.edit', 'group_name' => 'hr'],
            ['name' => 'designation.delete', 'group_name' => 'hr'],
            
            // Employees
            ['name' => 'employee.all', 'group_name' => 'hr'],
            ['name' => 'employee.add', 'group_name' => 'hr'],
            ['name' => 'employee.edit', 'group_name' => 'hr'],
            ['name' => 'employee.delete', 'group_name' => 'hr'],
            ['name' => 'employee.details', 'group_name' => 'hr'],
            
            // Attendance
            ['name' => 'attendance.all', 'group_name' => 'hr'],
            ['name' => 'attendance.add', 'group_name' => 'hr'],
            ['name' => 'attendance.delete', 'group_name' => 'hr'],
            
            // Payroll
            ['name' => 'payroll.all', 'group_name' => 'hr'],
            ['name' => 'payroll.add', 'group_name' => 'hr'],
            ['name' => 'payroll.details', 'group_name' => 'hr'],
            ['name' => 'payroll.delete', 'group_name' => 'hr'],
        ];

        foreach ($permissions as $item) {
            Permission::updateOrCreate(
                ['name' => $item['name']],
                ['group_name' => $item['group_name']]
            );
        }
    }
}
