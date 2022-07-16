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
        $vendedor->givePermissionTo('products.all');
        $vendedor->givePermissionTo('products.show');
        $vendedor->givePermissionTo('products.store');
        $vendedor->givePermissionTo('products.update');
        $vendedor->givePermissionTo('products.delete');

        $cliente = Role::create(['name' => 'Cliente']);
        $cliente->givePermissionTo('products.all');
        $cliente->givePermissionTo('shopping.all');
        $cliente->givePermissionTo('buy');
        

        
    }
}
