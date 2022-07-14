<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $superadmin = Role::create(['name' => 'Administrador']);
        Role::create(['name' => 'Vendedor']);
        Role::create(['name' => 'Cliente']);

        $superadmin->givePermissionTo(Permission::all());
    }
}
