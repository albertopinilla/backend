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

        $superadmin->givePermissionTo(Permission::all());

        $vendedor = Role::create(['name' => 'Vendedor']);

        $vendedor->givePermissionTo([
            'products.all',
            'products.show',
            'products.store',
            'products.update',
            'products.delete'
        ]);
       
        $cliente = Role::create(['name' => 'Cliente']);

        $cliente->givePermissionTo([
            'products.all',
            'shopping.all',
            'buy',
            'buy.update'
        ]);
    
    }
}
