<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => env('USER_NAME', 'Default Name'),
            'email' => env('USER_EMAIL', 'default@user'),
            'password' => env('USER_PASSWORD', 'default_password'),
            'is_admin' => true, // Define como administrador
        ]);
    }
}
