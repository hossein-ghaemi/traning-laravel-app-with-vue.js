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
            ['name' => 'Admin', 'nickName' => 'ad', 'order' => 10],
            ['name' => 'Common', 'nickName' => 'cm', 'order' => 20]
        ]);

    }
}
