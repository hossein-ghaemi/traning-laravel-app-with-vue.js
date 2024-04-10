<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AccessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Access::insert([
            ['route' => 'adminusersuserList', 'role_id' => 2, 'title' => 'Users List'],
        ]);
    }
}
