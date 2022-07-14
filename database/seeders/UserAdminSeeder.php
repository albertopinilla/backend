<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class UserAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Administrator',
            'email' => 'admin@admin.com',
            'password' => bcrypt('123456'),
        ]);
    }
}
