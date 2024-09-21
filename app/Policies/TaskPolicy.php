<?php

namespace App\Policies;

use App\Models\Employee;
use App\Models\Task;
use Illuminate\Auth\Access\HandlesAuthorization;

class TaskPolicy
{
    use HandlesAuthorization;

    public function viewAny(Employee $user)
    {
        return $user->role === 'admin' || $user->role === 'employee';
    }

    public function view(Employee $user, Task $task)
    {
        return $user->role === 'admin' || $task->employee_id === $user->id;
    }

    public function create(Employee $user)
    {
        return $user->role === 'admin';
    }

    public function update(Employee $user, Task $task)
    {
        return $user->role === 'admin' || $task->employee_id === $user->id;
    }

    public function delete(Employee $user, Task $task)
    {
        return $user->role === 'admin' || $task->employee_id === $user->id;
    }
}
