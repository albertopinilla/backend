<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserSeeder extends Seeder
{
    private $password = bcrypt('123456');

    public function run()
    {
        $admin = User::create([
            'name' => 'Administrator',
            'email' => 'admin@admin',
            'password' => $this->password,
        ]);

        $vendedor = User::create([
            'name' => 'Vendedor',
            'email' => 'vendedor@vendedor',
            'password' => $this->password,
        ]);

        $cliente = User::create([
            'name' => 'Cliente',
            'email' => 'cliente@cliente',
            'password' => $this->password,
        ]);

        $admin->assignRole('Administrador');
        $vendedor->assignRole('Vendedor');
        $cliente->assignRole('Cliente');
    }
}
