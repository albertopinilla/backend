<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::create([
            'name' => 'Administrator',
            'email' => 'admin@admin',
            'password' => bcrypt('123456'),
        ]);

        $vendedor = User::create([
            'name' => 'Vendedor',
            'email' => 'vendedor@vendedor',
            'password' => bcrypt('123456'),
        ]);

        $cliente = User::create([
            'name' => 'Cliente',
            'email' => 'cliente@cliente',
            'password' => bcrypt('123456'),
        ]);

        $admin->assignRole('Administrador');
        $vendedor->assignRole('Vendedor');
        $cliente->assignRole('Cliente');
    }
}
