<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Services\EmployeeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Models\Employee;

class EmployeeController extends Controller
{
    protected $employeeService;

    public function __construct(EmployeeService $employeeService)
    {
        $this->employeeService = $employeeService;

        $this->middleware('auth');

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
        $this->authorize('create', Employee::class);

        $managers = $this->employeeService->getAllEmployees();
        $departments = app('App\Services\DepartmentService')->getAllDepartments(); // افترض أن لديك DepartmentService

        return view('employees.create', compact('managers', 'departments'));
    }

    public function store(StoreEmployeeRequest $request)
    {
        $this->authorize('create', Employee::class);

        $employee = $this->employeeService->createEmployee($request->validated());

        if ($request->expectsJson()) {
            return response()->json($employee, 201);
        }

        return redirect()->route('employees.index')->with('success', 'تم إنشاء الموظف بنجاح.');
    }

    public function edit($id)
    {
        $employee = $this->employeeService->getEmployeeById($id);

        $this->authorize('update', $employee);

        $managers = $this->employeeService->getAllEmployees();
        $departments = app('App\Services\DepartmentService')->getAllDepartments();

        return view('employees.edit', compact('employee', 'managers', 'departments'));
    }

    public function update(UpdateEmployeeRequest $request, $id)
    {
        $employee = $this->employeeService->getEmployeeById($id);

        // تحقق من الصلاحيات
        $this->authorize('update', $employee);

        $this->employeeService->updateEmployee($id, $request->validated());

        if ($request->expectsJson()) {
            return response()->json($employee);
        }

        return redirect()->route('employees.index')->with('success', 'تم تحديث الموظف بنجاح.');
    }

    public function destroy(Request $request, $id)
    {
        $employee = $this->employeeService->getEmployeeById($id);

        $this->authorize('delete', $employee);

        $this->employeeService->deleteEmployee($id);

        if ($request->expectsJson()) {
            return response()->json(['message' => 'تم حذف الموظف بنجاح.']);
        }

        return redirect()->route('employees.index')->with('success', 'تم حذف الموظف بنجاح.');
    }

    public function show($id)
    {
        $employee = $this->employeeService->getEmployeeById($id);
        $this->authorize('view', $employee);

        return view('employees.show', compact('employee'));
    }
}
