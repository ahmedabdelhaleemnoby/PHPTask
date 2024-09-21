<?php

namespace App\Http\Controllers;

use App\Services\EmployeeService;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Department;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;


class EmployeeController extends Controller
{
    protected $employeeService;

    public function __construct(EmployeeService $employeeService)
    {
        $this->employeeService = $employeeService;

        $this->middleware('role:admin')->only(['create', 'store', 'edit', 'update', 'destroy']);
    }

    public function index(Request $request)
    {
        if (Auth::user()->role === 'admin') {
            $employees = $this->employeeService->getAllEmployees();
        } else {
            $employees = [$this->employeeService->getEmployeeById(Auth::id())];
        }

        if ($request->expectsJson()) {
            return response()->json($employees);
        }

        return view('employees.index', compact('employees'));
    }

    public function create()
    {
        $managers = Employee::all();
        $departments = Department::all();
        return view('employees.create', compact('managers', 'departments'));
    }

    public function store(Request $request)
    {
        try {
            $employee = $this->employeeService->createEmployee($request->all());

            if ($request->expectsJson()) {
                return response()->json($employee, 201);
            }

            return redirect()->route('employees.index');
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->validator)->withInput();
        }
    }

    public function edit($id)
    {
        $employee = Employee::findOrFail($id);
        $managers = Employee::all();
        $departments = Department::all();
        return view('employees.edit', compact('employee', 'managers', 'departments'));
    }

    public function update(Request $request, $id)
    {
        try {
            $employee = $this->employeeService->updateEmployee($id, $request->all());

            if ($request->expectsJson()) {
                return response()->json($employee);
            }

            return redirect()->route('employees.index');
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->validator)->withInput();
        }
    }

    public function destroy(Request $request, $id)
    {
        $this->employeeService->deleteEmployee($id);

        if ($request->expectsJson()) {
            return response()->json(['message' => 'Employee deleted successfully.']);
        }

        return redirect()->route('employees.index');
    }
}
