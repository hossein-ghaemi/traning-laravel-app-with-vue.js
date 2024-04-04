<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'fName' => fake()->name(),
            'lName' => fake()->name(),
            'email' => 'jamshid.gh78@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('88222564'),
            'remember_token' => Str::random(10),
        ]);
    }
}
