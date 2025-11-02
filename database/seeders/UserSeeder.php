<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::query()
            ->create([
                'name' => 'Demo User',
                'email' => 'demo@noteloom.com',
                'password' => Hash::make('yFvvYxs!RYPR1fY2gNu&%Wy#LwFpicik'),
            ]);
    }
}
