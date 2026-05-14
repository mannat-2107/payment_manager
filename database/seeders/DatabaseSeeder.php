<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Department;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(RoleSeeder::class);

        Department::insert([
            ['name' => 'Human Resources',  'description' => 'HR department',      'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Engineering',       'description' => 'Tech department',    'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Finance',           'description' => 'Finance department', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Operations',        'description' => 'Ops department',     'created_at' => now(), 'updated_at' => now()],
        ]);

        $this->call(AdminSeeder::class);
    }
}