<?php

namespace App\Services;

use App\Repositories\TaskRepository;
use Illuminate\Support\Facades\Auth;

class TaskService
{
    protected $taskRepository;

    public function __construct(TaskRepository $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    public function getAllTasks($perPage = 15)
    {
        if (Auth::user()->role === 'admin') {
            return $this->taskRepository->getAllTasks($perPage);
        } else {
            return $this->taskRepository->getTasksByEmployeeId(Auth::id(), $perPage);
        }
    }

    public function getTaskById($id)
    {
        return $this->taskRepository->getTaskById($id);
    }

    public function createTask(array $data)
    {

        return $this->taskRepository->createTask($data);
    }

    public function updateTask($id, array $data)
    {

        return $this->taskRepository->updateTask($id, $data);
    }

    public function deleteTask($id)
    {
        return $this->taskRepository->deleteTask($id);
    }
}
