<?php

namespace App\Services;

use App\Repositories\EmployeeRepository;

class EmployeeService
{
    protected $employeeRepository;

    public function __construct(EmployeeRepository $employeeRepository)
    {
        $this->employeeRepository = $employeeRepository;
    }

    public function getAllEmployees(array $filters = [], $perPage = 15)
    {
        return $this->employeeRepository->getAllEmployees($filters, $perPage);
    }

    public function getEmployeeById($id)
    {
        return $this->employeeRepository->getEmployeeById($id);
    }

    public function createEmployee(array $data)
    {

        return $this->employeeRepository->createEmployee($data);
    }

    public function updateEmployee($id, array $data)
    {

        return $this->employeeRepository->updateEmployee($id, $data);
    }

    public function deleteEmployee($id)
    {
        return $this->employeeRepository->deleteEmployee($id);
    }
}
