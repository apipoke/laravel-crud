<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\User::create([
          'name' => 'Abu Dzar Al-Ghifari',
          'username' => 'abudzar',
          'email' => 'abudzar@gmail.com',
          'password' => bcrypt('password')
        ]);
    }
}
