<?php

namespace App\Repositories;

use App\Models\Department;

class DepartmentRepository
{
    public function getAllDepartments($perPage = 15)
    {
        return Department::paginate($perPage);
    }

    public function getDepartmentById($id)
    {
        return Department::findOrFail($id);
    }

    public function createDepartment(array $data)
    {
        return Department::create($data);
    }

    public function updateDepartment($id, array $data)
    {
        $department = $this->getDepartmentById($id);
        $department->update($data);

        return $department;
    }

    public function deleteDepartment($id)
    {
        $department = $this->getDepartmentById($id);
        $department->delete();

        return true;
    }
}
