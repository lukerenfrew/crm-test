<?php

use App\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'email' => 'admin@admin.com',
            'password' => bcrypt('password'),
            'name' => 'admin user'
        ]);
    }
}
