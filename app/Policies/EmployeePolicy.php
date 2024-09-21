<?php

namespace App\Policies;

use App\Models\Employee;
use Illuminate\Auth\Access\HandlesAuthorization;

class EmployeePolicy
{
    use HandlesAuthorization;

    public function viewAny(Employee $user)
    {
        return $user->role === 'admin';
    }

    public function view(Employee $user, Employee $employee)
    {
        return $user->role === 'admin' || $user->id === $employee->id;
    }

    public function create(Employee $user)
    {
        return $user->role === 'admin';
    }

    public function update(Employee $user, Employee $employee)
    {
        return $user->role === 'admin' || $user->id === $employee->id;
    }

    public function delete(Employee $user, Employee $employee)
    {
        return $user->role === 'admin';
    }
}
