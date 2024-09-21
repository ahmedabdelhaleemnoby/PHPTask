<?php

namespace App\Repositories;

use App\Models\Employee;

class EmployeeRepository
{
    public function getAllEmployees(array $filters = [], $perPage = 15)
    {
        $query = Employee::query();

        if (isset($filters['department_id'])) {
            $query->where('department_id', $filters['department_id']);
        }

        if (isset($filters['manager_id'])) {
            $query->where('manager_id', $filters['manager_id']);
        }


        return $query->paginate($perPage);
    }

    public function getEmployeeById($id)
    {
        return Employee::findOrFail($id);
    }

    public function createEmployee(array $data)
    {
        $employee = new Employee($data);
        $employee->save();

        return $employee;
    }

    public function updateEmployee($id, array $data)
    {
        $employee = $this->getEmployeeById($id);

        $employee->fill($data);

        $employee->save();

        return $employee;
    }

    public function deleteEmployee($id)
    {
        $employee = $this->getEmployeeById($id);
        $employee->delete();

        return true;
    }
}
