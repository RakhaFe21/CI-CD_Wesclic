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
          'email' => 'admin@gmail.com',
          'nik' => '123456789',
          'password' => Hash::make('12345678'),
          'user_type' => 'Admin',
          'banned' => false,
          'verified' => true,
          'image' => 'uploads/user/nfkUiXvcdhYfWol7esVLtUxZ0kOqTkvC2FMsYiNa.png',
      ]);
    }
}
