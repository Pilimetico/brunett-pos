<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            'ver_dashboard',
            'usar_pos',
            'gestionar_inventario',
            'gestionar_clientes',
            'gestionar_compras',
            'gestionar_cajas',
            'ver_reportes',
            'gestionar_configuracion',
            'gestionar_usuarios',
            'aprobar_autorizaciones'
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }
    }
}
