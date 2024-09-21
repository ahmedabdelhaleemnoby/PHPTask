<?php

namespace App\Repositories;

use App\Models\Task;

class TaskRepository
{
    public function getAllTasks()
    {
        return Task::all();
    }

    public function getTasksByEmployeeId($employeeId)
    {
        return Task::where('employee_id', $employeeId)->get();
    }

    public function getTaskById($id)
    {
        return Task::findOrFail($id);
    }

    public function createTask(array $data)
    {
        return Task::create($data);
    }

    public function updateTask($id, array $data)
    {
        $task = $this->getTaskById($id);
        $task->update($data);
        return $task;
    }


    public function deleteTask($id)
    {
        $task = $this->getTaskById($id);
        $task->delete();
    }
}
