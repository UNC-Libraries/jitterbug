<?php

use Illuminate\Database\Seeder;
use Jitterbug\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(env('APP_ENV') != 'production')
        {
            $password = Hash::make(env('ADMIN_USER_PASSWORD');

            $users[] = [
                'email' => 'admin@jitterbug.com',
                'admin' => 1,
                'username' => 'dev-admin',
                'password' => $password
            ];

            User::insert($users);
        }
    }
}
