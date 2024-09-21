<?php

namespace App\Services;

use App\Repositories\DepartmentRepository;

class DepartmentService
{
    protected $departmentRepository;

    public function __construct(DepartmentRepository $departmentRepository)
    {
        $this->departmentRepository = $departmentRepository;
    }

    public function getAllDepartments($perPage = 15)
    {
        return $this->departmentRepository->getAllDepartments($perPage);
    }

    public function getDepartmentById($id)
    {
        return $this->departmentRepository->getDepartmentById($id);
    }

    public function createDepartment(array $data)
    {

        return $this->departmentRepository->createDepartment($data);
    }

    public function updateDepartment($id, array $data)
    {

        return $this->departmentRepository->updateDepartment($id, $data);
    }

    public function deleteDepartment($id)
    {
        $department = $this->getDepartmentById($id);

        if ($department->employees()->count() > 0) {
            return false;
        }

        return $this->departmentRepository->deleteDepartment($id);
    }
}
