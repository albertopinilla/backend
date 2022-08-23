<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    
    private $product_all = 'products.all';
    private $product_show = 'products.show',

    public function run()
    {
        

        $logout = 'auth.logout';
      
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
            $this->products_all,
            $this->product_show,
            'products.store',
            'products.update',
            'products.delete',
            'sales.all',

            'auth.me',
            $logout
        ]);

        $vendedor = Role::create(['name' => 'Vendedor']);

        $vendedor->givePermissionTo([
            $this->products_all,
            $this->product_show,
            'products.store',
            'products.update',
            'products.delete',

            'auth.me',
            $logout
        ]);
       
        $cliente = Role::create(['name' => 'Cliente']);

        $cliente->givePermissionTo([
            $this->products_all,
            $this->product_show,
            'shopping.all',
            'buy',
            'buy.update',

            'auth.me',
            $logout
        ]);
    
    }
}
