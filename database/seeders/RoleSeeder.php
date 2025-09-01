<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Membuat Roles
        Role::firstOrCreate(['name' => 'user', 'guard_name' => 'web', 'display_name' => 'User', 'description' => 'Peran untuk pengguna biasa']);
        Role::firstOrCreate(['name' => 'editor', 'guard_name' => 'web', 'display_name' => 'Editor', 'description' => 'Peran untuk mengelola konten']);
        Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web', 'display_name' => 'Administrator', 'description' => 'Peran untuk administrasi sistem']);
        Role::firstOrCreate(['name' => 'super-admin', 'guard_name' => 'web', 'display_name' => 'Super Admin', 'description' => 'Peran dengan akses tak terbatas']);
    }
}
