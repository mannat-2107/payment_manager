<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Create roles only if they don't exist
        Role::firstOrCreate(['name' => 'super-admin']);
        Role::firstOrCreate(['name' => 'hr-manager']);
        Role::firstOrCreate(['name' => 'accountant']);
        Role::firstOrCreate(['name' => 'employee']);

        // Create permissions only if they don't exist
        Permission::firstOrCreate(['name' => 'manage employees']);
        Permission::firstOrCreate(['name' => 'run payroll']);
        Permission::firstOrCreate(['name' => 'process payments']);
        Permission::firstOrCreate(['name' => 'view reports']);
        Permission::firstOrCreate(['name' => 'manage leaves']);

        // Assign permissions to roles
        Role::findByName('super-admin')->givePermissionTo(Permission::all());
        Role::findByName('hr-manager')->givePermissionTo(['manage employees', 'manage leaves', 'view reports']);
        Role::findByName('accountant')->givePermissionTo(['run payroll', 'process payments', 'view reports']);
        Role::findByName('employee')->givePermissionTo(['view reports']);
    }
}