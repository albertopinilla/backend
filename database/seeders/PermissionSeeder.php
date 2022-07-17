<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::create(['name' => 'users.all']);
        Permission::create(['name' => 'users.show']);
        Permission::create(['name' => 'users.store']);
        Permission::create(['name' => 'users.update']);
        Permission::create(['name' => 'users.delete']);

        Permission::create(['name' => 'roles.all']);
        Permission::create(['name' => 'roles.show']);
        Permission::create(['name' => 'roles.store']);
        Permission::create(['name' => 'roles.update']);
        Permission::create(['name' => 'roles.delete']);

        Permission::create(['name' => 'products.all']);
        Permission::create(['name' => 'products.show']);
        Permission::create(['name' => 'products.store']);
        Permission::create(['name' => 'products.update']);
        Permission::create(['name' => 'products.delete']);

        Permission::create(['name' => 'shopping.all']);
        Permission::create(['name' => 'buy']);
        Permission::create(['name' => 'buy.update']);

    }
}
