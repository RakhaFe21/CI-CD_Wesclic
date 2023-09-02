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
          'nik' => '1234567',
          'email' => 'admin@gmail.com',
          // 'phone' => '083801160107',
          'password' => Hash::make('123'),
          'user_type' => 'Admin',
          'banned' => false,
          'verified' => true,
          'image' => 'uploads/user/nfkUiXvcdhYfWol7esVLtUxZ0kOqTkvC2FMsYiNa.png',
      ]);
    }
}
