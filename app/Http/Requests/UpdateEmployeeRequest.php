<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEmployeeRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $employeeId = $this->route('employee');

        return [
            'first_name'     => 'required|string|max:255',
            'last_name'      => 'required|string|max:255',
            'email'          => 'required|email|unique:employees,email,' . $employeeId,
            'phone'          => 'required|unique:employees,phone,' . $employeeId,
            'password'       => 'nullable|string|min:8',
            'salary'         => 'required|numeric',
            'role'           => 'required|string|in:admin,employee',
            'manager_id'     => 'nullable|exists:employees,id',
            'department_id'  => 'nullable|exists:departments,id',
        ];
    }
}
