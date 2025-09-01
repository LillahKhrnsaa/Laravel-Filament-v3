<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class MakeCustomFilamentResource extends Command
{
    protected $signature = 'make:custom-filament-resource {name}';
    protected $description = 'Creates a Filament resource and policy with specific CRUD permissions.';

    public function handle()
    {
        $name = $this->argument('name');
        $resourceName = Str::studly($name);
        $modelName = $resourceName;
        $tableName = Str::snake(Str::plural($name));

        // Langkah 1: Buat Filament Resource
        $this->info("Creating Filament Resource for '{$resourceName}'...");
        Artisan::call("make:filament-resource {$resourceName}");

        // Langkah 2: Buat Policy
        $this->info("Creating Policy for '{$modelName}'...");
        Artisan::call("make:policy {$modelName}Policy --model={$modelName}");

        // POIN UTAMA: Modifikasi Policy yang baru dibuat
        $policyFilePath = app_path("Policies/{$modelName}Policy.php");
        if (File::exists($policyFilePath)) {
            $policyContent = File::get($policyFilePath);

            $permissions = [
                'viewAny' => "viewAny.{$tableName}",
                'view' => "view.{$tableName}",
                'create' => "create.{$tableName}",
                'update' => "update.{$tableName}",
                'delete' => "delete.{$tableName}",
            ];

            foreach ($permissions as $method => $permissionName) {
                // Tentukan argumen fungsi
                $modelArgument = "";
                $canCallArgument = "";
                if ($method !== 'viewAny' && $method !== 'create') {
                    $modelArgument = ", {$modelName} \${$tableName}";
                    $canCallArgument = ", \${$tableName}";
                }

                // Buat definisi fungsi baru yang akan menggantikan yang lama
                $newFunction = "public function {$method}(User \$user{$modelArgument}): bool\n    {\n        return \$user->can('{$permissionName}'{$canCallArgument});\n    }";

                // Mencari dan mengganti seluruh fungsi dengan regex
                // Regex ini jauh lebih andal karena tidak peduli dengan spasi atau indentasi
                $pattern = "/public function {$method}\([^)]*\): bool\s*\{\s*(?:.|[\r\n])*?}/";
                $policyContent = preg_replace($pattern, $newFunction, $policyContent, 1);
            }
            
            // Simpan kembali file yang sudah dimodifikasi
            File::put($policyFilePath, $policyContent);
            $this->info("Policy for '{$modelName}' modified successfully to check for permissions.");
        }

        // Langkah 3: Buat Permission yang spesifik
        $this->info("Creating specific permissions...");
        $permissionNames = array_values($permissions);

        foreach ($permissionNames as $permissionName) {
            Permission::firstOrCreate(['name' => $permissionName]);
        }

        // --- Bagian baru untuk menambahkan permission ke super_admin ---
        $this->info("Assigning permissions to 'super-admin' role...");

        // Cari atau buat peran super_admin
        $superAdminRole = Role::firstOrCreate(['name' => 'super-admin']);

        // Ambil semua permission yang baru saja dibuat
        $newPermissions = Permission::whereIn('name', $permissionNames)->get();

        // Berikan semua permission baru ke peran super_admin
        $superAdminRole->givePermissionTo($newPermissions);

        // --- Akhir dari bagian baru ---

        $this->info("Permissions for '{$tableName}' created and assigned to super-admin.");
        $this->info("All done! Your new resource is ready.");
    }
}
