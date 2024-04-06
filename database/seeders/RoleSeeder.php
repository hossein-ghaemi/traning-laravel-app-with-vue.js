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
            ['name' => 'User', 'nick_name' => 'user'],
            ['name' => 'Admin', 'nick_name' => 'admin'],
            ['name' => 'Manager', 'nick_name' => 'manager'],
            ['name' => 'Customer', 'nick_name' => 'customer'],
            ['name' => 'Supplier', 'nick_name' => 'supplier'],
        ]);

    }
}
