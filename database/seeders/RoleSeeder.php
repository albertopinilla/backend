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

        $superadmin->givePermissionTo([
            'users.all',
            'users.show',
            'users.store',
            'users.update',
            'users.delete',
            'roles.all',
            'roles.show',
            'roles.store',
            'roles.update',
            'roles.delete',
            'products.all',
            'products.show',
            'products.store',
            'products.update',
            'products.delete',
            'sales.all',

            'auth.me',
            'auth.logout'
        ]);

        $vendedor = Role::create(['name' => 'Vendedor']);

        $vendedor->givePermissionTo([
            'products.all',
            'products.show',
            'products.store',
            'products.update',
            'products.delete',

            'auth.me',
            'auth.logout'
        ]);
       
        $cliente = Role::create(['name' => 'Cliente']);

        $cliente->givePermissionTo([
            'products.all',
            'products.show',
            'shopping.all',
            'buy',
            'buy.update',

            'auth.me',
            'auth.logout'
        ]);
    
    }
}
