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
        [
            User::create([
                'fullname' => 'Admin CMS',
                'username' => 'admin',
                'email' => 'admincms@gmail.com',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'status' => 'active',
            ]),

            User::create([
                'fullname' => 'Author CMS',
                'username' => 'author',
                'email' => 'authorcms@gmail.com',
                'password' => Hash::make('author123'),
                'role' => 'author',
                'status' => 'active',
            ]),
        ];
    }
}
