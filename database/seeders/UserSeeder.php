<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\ServiceSubCategory;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    // public function runs(): void
    // {
    //     $users = [
    //         [
    //             'name' => 'Blale Brentha',
    //             'password' => bcrypt('password'),
    //             'email' => 'employee1@gmail.com',
    //             'image' => 'uploads/images/avatar.png',
    //         ],
    //         [
    //             'name' => 'Adam Taylor',
    //             'password' => bcrypt('password'),
    //             'email' => 'employee2@gmail.com',
    //             'image' => 'uploads/images/avatar.png',
    //         ]
    //     ];

    //     User::insert($users);    
    // }

    public function run(): void
    {
        if (User::count() == 0) {
            for ($i = 1; $i <= 3; $i++) {
                $user = User::create([
                    'name' => fake()->name(),
                    'email' => "employee{$i}@example.com",
                    'password' => bcrypt('password'),
                    'image' => 'uploads/images/avatar.png',
                    'phone' => fake()->phoneNumber(),
                    'role' => 'employee',
                ]);

                $employee = Employee::create([
                    'user_id' => $user->id,
                    'days' => [
                        'monday'    => ['08:00-20:00'],
                        'tuesday'   => ['08:00-20:00'],
                        'wednesday' => ['08:00-20:00'],
                        'thursday' => ['08:00-20:00'],
                        'friday'    => ['08:00-20:00'],
                    ],

                    'slot_duration' => 30,
                    'break_duration' => 15,
                ]);

                // assign employee to random 2–3 services
                $serviceIds = ServiceSubCategory::inRandomOrder()->take(3)->pluck('id');
                $employee->services()->sync($serviceIds);
            }
        }
    }
}