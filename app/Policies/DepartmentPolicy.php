<?php

namespace App\Policies;

use App\Models\Department;
use App\Models\Employee;
use Illuminate\Auth\Access\HandlesAuthorization;

class DepartmentPolicy
{
    use HandlesAuthorization;

    public function viewAny(Employee $user)
    {
        return $user->role === 'admin' || $user->role === 'employee';
    }

    public function view(Employee $user, Department $department)
    {
        return $user->role === 'admin' || $user->department_id === $department->id;
    }

    public function create(Employee $user)
    {
        return $user->role === 'admin';
    }

    public function update(Employee $user, Department $department)
    {
        return $user->role === 'admin';
    }

    public function delete(Employee $user, Department $department)
    {
        return $user->role === 'admin';
    }
}
