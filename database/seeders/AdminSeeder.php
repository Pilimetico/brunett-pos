<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $role = Role::firstOrCreate(['name' => 'Administrador']);
        $role->syncPermissions(Permission::all());
        
        $user = User::first(); // Grab the first user (usually admin@brunett.com)
        if ($user) {
            $user->assignRole('Administrador');
        }
    }
}
