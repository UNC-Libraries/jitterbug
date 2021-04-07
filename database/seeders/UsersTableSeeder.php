<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Jitterbug\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(env('APP_ENV') !== 'production')
        {
          $password = Hash::make(env('ADMIN_USER_PASSWORD'));
          $users[] = [
            'first_name' => 'Dev',
            'last_name' => 'Admin',
            'email' => 'admin@jitterbug.com',
            'admin' => 1,
            'username' => 'dev-admin',
            'password' => $password
          ];
          User::insert($users);
        }
    }
}
