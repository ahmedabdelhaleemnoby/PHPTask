<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDepartmentRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $departmentId = $this->route('department'); 

        return [
            'name'       => 'required|string|max:255|unique:departments,name,' . $departmentId,
            'manager_id' => 'nullable|exists:employees,id',
        ];
    }
}
