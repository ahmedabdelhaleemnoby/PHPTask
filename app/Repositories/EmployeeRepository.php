<?php

namespace App\Repositories;

use App\Models\Employee;

class EmployeeRepository
{
    public function getAllEmployees()
    {
        return Employee::all();
    }

    public function getEmployeeById($id)
    {
        return Employee::findOrFail($id);
    }

    public function createEmployee(array $data)
    {
        $data['password'] = bcrypt($data['password']);
        return Employee::create($data);
    }

    public function updateEmployee($id, array $data)
    {
        $employee = $this->getEmployeeById($id);

        if (!empty($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        } else {
            unset($data['password']);
        }

        $employee->update($data);
        return $employee;
    }

    public function deleteEmployee($id)
    {
        $employee = $this->getEmployeeById($id);
        $employee->delete();
    }
}
