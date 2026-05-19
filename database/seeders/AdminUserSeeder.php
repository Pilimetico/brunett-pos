<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::updateOrCreate(
            ['email' => 'admin@brunett.com'],
            [
                'name' => 'Administrador',
                'password' => Hash::make('admin123')
            ]
        );
    }
}
