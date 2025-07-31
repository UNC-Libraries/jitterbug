<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Jitterbug\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (env('APP_ENV') !== 'production') {
            $password = Hash::make(env('ADMIN_USER_PASSWORD'));
            User::updateOrCreate([
                'username' => 'admin',
            ], [
                'first_name' => 'Dev',
                'last_name' => 'Admin',
                'email' => 'admin@jitterbug.com',
                'admin' => 1,
                'username' => 'admin',
                'password' => $password,
            ]);
        }
    }
}
