<?php

namespace App\Services;

use App\Repositories\DepartmentRepository;
use Illuminate\Support\Facades\Auth;

class DepartmentService
{
    protected $departmentRepository;

    public function __construct(DepartmentRepository $departmentRepository)
    {
        $this->departmentRepository = $departmentRepository;
    }

    public function getAllDepartments()
    {
        if (Auth::user()->role === 'admin') {
            return $this->departmentRepository->getAllDepartments();
        } else {
            return $this->departmentRepository->getDepartmentById(Auth::user()->department_id);
        }
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
            return ['error' => "Cannot delete department with employees. Please remove employees first."];
        }

        return $this->departmentRepository->deleteDepartment($id);
    }
}
