<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('users')->insert([
          'name' => 'Admin',
<<<<<<< HEAD
          'email' => 'admin@gmail.com',
          'nik' => '123456789',
=======
          'nik' => '1234567',
          'email' => 'admin@gmail.com',
>>>>>>> a46021b1810337e5a7f07500ed5ae46f7855b13e
          'password' => Hash::make('12345678'),
          'user_type' => 'Admin',
          'banned' => false,
          'verified' => true,
          'image' => 'uploads/user/nfkUiXvcdhYfWol7esVLtUxZ0kOqTkvC2FMsYiNa.png',
      ]);
    }
}
