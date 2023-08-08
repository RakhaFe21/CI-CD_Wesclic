<?php

use Illuminate\Support\Carbon;
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
          'nik' => '1234567',
          'email' => 'admin@gmail.com',
          'nik' => '1234567',
          'email' => 'admin@gmail.com',
=======
          'email' => 'admin@mail.com',
          'nik' => '325634634',
>>>>>>> 1cc72048eea5031fe2f28e2acad819236a8b40a1
          'password' => Hash::make('12345678'),
          'user_type' => 'Admin',
          'banned' => false,
          'verified' => true,
          'image' => 'uploads/user/nfkUiXvcdhYfWol7esVLtUxZ0kOqTkvC2FMsYiNa.png',
          'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
          'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
      ]);
      
    }
}
