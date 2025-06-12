<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Blale Brentha',
                'password' => bcrypt('password'),
                'email' => 'employee1@gmail.com',
            ],
            [
                'name' => 'Adam Taylor',
                'password' => bcrypt('password'),
                'email' => 'employee2@gmail.com',
            ]
        ];

        User::insert($users);    
    }
}
