<?php

use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Vishnu A K',
            'email' => 'vishnuak14@gmail.com',
            'role' => 'superadmin',
            'password' => Hash::make('12345678'),
            'is_active' => 1,
        ]);
    }
}
