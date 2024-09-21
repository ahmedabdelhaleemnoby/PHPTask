<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Employee;
use Illuminate\Support\Facades\Hash;
use App\Models\Department;
class EmployeeSeeder extends Seeder
{
    public function run()
    {
        $department = Department::first();
        Employee::create([
            'first_name' => 'abdo',
            'last_name' => 'saad',
            'email' => 'abdosaad@gmail.com',
            'phone' => '1234567890',
            'password' => Hash::make('password'),
            'salary' => 5000,
            'manager_id' => null,
            'department_id' => $department ? $department->id : null,
        ]);

        Employee::create([
            'first_name' => 'ali',
            'last_name' => 'saad',
            'email' => 'alisaad@gmail.com',
            'phone' => '0987654321',
            'password' => Hash::make('password'),
            'salary' => 7000,
            'manager_id' => 1,
            'department_id' => $department ? $department->id : null,
        ]);
    }
}
