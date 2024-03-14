<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'User test',
            'email' => 'test@example.com',
            'password' => Hash::make('123456'),
            'age' => '20',
            'address' => '123 Main Street',
        ]);
    }
}
