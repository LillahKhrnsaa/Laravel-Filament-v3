<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Membuat Super Admin
        $superAdmin = User::firstOrCreate(
            ['email' => 'superadmin@tamarisgroup.com'],
            [
                'name' => 'Super Admin',
                'username' => 'super_admin',
                'password' => Hash::make('1234567890'), // ganti dengan password yang aman
            ]
        );
        $superAdmin->assignRole('super-admin');

        // Membuat Admin
        $admin = User::firstOrCreate(
            ['email' => 'admin@tamarisgroup.com'],
            [
                'name' => 'Administrator',
                'username' => 'admin',
                'password' => Hash::make('1234567890'),
            ]
        );
        $admin->assignRole('admin');

        // Membuat Editor
        $editor = User::firstOrCreate(
            ['email' => 'editor@tamarisgroup.com'],
            [
                'name' => 'Editor',
                'username' => 'editor',
                'password' => Hash::make('1234567890'),
            ]
        );
        $editor->assignRole('editor');

        // Membuat User Biasa
        $user = User::firstOrCreate(
            ['email' => 'user@tamarisgroup.com'],
            [
                'name' => 'John Doe',
                'username' => 'johndoe',
                'password' => Hash::make('1234567890'),
            ]
        );
        $user->assignRole('user');
    }
}
