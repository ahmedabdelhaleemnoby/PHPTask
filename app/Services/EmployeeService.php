<?php

namespace App\Services;

use App\Repositories\EmployeeRepository;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class EmployeeService
{
    protected $employeeRepository;

    public function __construct(EmployeeRepository $employeeRepository)
    {
        $this->employeeRepository = $employeeRepository;
    }

    public function getAllEmployees(array $filters = [])
    {
        return $this->employeeRepository->getAllEmployees();
    }

    public function getEmployeeById($id)
    {
        return $this->employeeRepository->getEmployeeById($id);
    }

    public function createEmployee(array $data)
    {
        $validator = Validator::make($data, [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email',
            'phone' => 'required|unique:employees,phone',
            'password' => 'required|string|min:8',
            'salary' => 'required|numeric',
            'role' => 'required|string|in:admin,employee', // التحقق من الدور
            'manager_id' => 'nullable|exists:employees,id',
            'department_id' => 'nullable|exists:departments,id',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return $this->employeeRepository->createEmployee($data);
    }

    public function updateEmployee($id, array $data)
    {
        $validator = Validator::make($data, [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email,' . $id,
            'phone' => 'required|unique:employees,phone,' . $id,
            'salary' => 'required|numeric',
            'role' => 'required|string|in:admin,employee', // التحقق من الدور
            'manager_id' => 'nullable|exists:employees,id',
            'department_id' => 'nullable|exists:departments,id',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return $this->employeeRepository->updateEmployee($id, $data);
    }

    public function deleteEmployee($id)
    {
        return $this->employeeRepository->deleteEmployee($id);
    }
}
