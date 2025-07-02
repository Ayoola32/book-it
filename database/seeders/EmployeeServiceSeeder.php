<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\ServiceSubCategory;
use Illuminate\Database\Seeder;


class EmployeeServiceSeeder extends Seeder
{
    public function run()
    {
        // check if pivot table already has records
        if (\DB::table('employee_service_sub_category')->count() > 0) {
            $this->command->info('Employee services already seeded. Skipping.');
            return;
        }

        $employees = Employee::all();
        $services = ServiceSubCategory::all();

        foreach ($employees as $employee) {
            $serviceIds = $services->random(rand(2,4))->pluck('id')->toArray();
            $employee->services()->sync($serviceIds);
        }
    }
}

