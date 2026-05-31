<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'rynzexel15@gmail.com'],
            [
                'name' => 'shin6',
                'password' => Hash::make('coffelafte!'),
                'role' => 'admin',
                'email_verified_at' => 'now',
            ]
        );
    }
}
