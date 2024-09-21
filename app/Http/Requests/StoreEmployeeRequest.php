<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEmployeeRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'first_name'     => 'required|string|max:255',
            'last_name'      => 'required|string|max:255',
            'email'          => 'required|email|unique:employees,email',
            'phone'          => 'required|unique:employees,phone',
            'password'       => 'required|string|min:8',
            'salary'         => 'required|numeric',
            'role'           => 'required|string|in:admin,employee',
            'manager_id'     => 'nullable|exists:employees,id',
            'department_id'  => 'nullable|exists:departments,id',
        ];
    }
}
