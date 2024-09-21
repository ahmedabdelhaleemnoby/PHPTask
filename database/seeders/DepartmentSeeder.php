<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Department;

class DepartmentSeeder extends Seeder
{
    public function run()
    {
        Department::create([
            'name' => 'IT',
            'manager_id' => 1, // Assuming the manager of IT
        ]);

        Department::create([
            'name' => 'HR',
            'manager_id' => 2, // Assuming the manager of HR
        ]);
    }
}
