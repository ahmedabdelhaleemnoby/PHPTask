<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Task;

class TaskSeeder extends Seeder
{
    public function run()
    {
        Task::create([
            'title' => 'Complete Project',
            'description' => 'Complete the project by the end of the week.',
            'status' => 'in-progress',
            'employee_id' => 2, // Assuming responsible for this task
        ]);

        Task::create([
            'title' => 'Prepare Presentation',
            'description' => 'Prepare the presentation for the client meeting.',
            'status' => 'pending',
            'employee_id' => 1, // Assuming responsible for this task
        ]);
    }
}
