<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Role::insert([
            ['name' => 'Admin', 'nick_name' => 'admin'],
            ['name' => 'User', 'nick_name' => 'user'],
            ['name' => 'Manager', 'nick_name' => 'manager'],
            ['name' => 'Customer', 'nick_name' => 'customer'],
            ['name' => 'Supplier', 'nick_name' => 'supplier'],
        ]);

    }
}
