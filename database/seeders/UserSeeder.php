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
        User::query()->create([
            'first_name' => 'Admin',
            'last_name'  => 'Test',
            'username'   => 'admintest',
            'password'   => Hash::make('password'),
        ]);
    }
}
