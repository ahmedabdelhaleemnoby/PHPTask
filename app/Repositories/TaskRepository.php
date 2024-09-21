<?php

namespace App\Repositories;

use App\Models\Task;

class TaskRepository
{
    public function getAllTasks($perPage = 15)
    {
        return Task::paginate($perPage);
    }

    public function getTasksByEmployeeId($employeeId, $perPage = 15)
    {
        return Task::where('employee_id', $employeeId)->paginate($perPage);
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

        return true;
    }
}
