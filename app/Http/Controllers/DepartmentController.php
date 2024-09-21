<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDepartmentRequest;
use App\Http\Requests\UpdateDepartmentRequest;
use App\Services\DepartmentService;
use App\Services\EmployeeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Department;

class DepartmentController extends Controller
{
    protected $departmentService;
    protected $employeeService;

    public function __construct(DepartmentService $departmentService, EmployeeService $employeeService)
    {
        $this->departmentService = $departmentService;
        $this->employeeService = $employeeService;

        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $this->authorize('viewAny', Department::class);

        if (Auth::user()->role === 'employee') {
            $department = $this->departmentService->getDepartmentById(Auth::user()->department_id);
            $departments = $department ? [$department] : [];
        } else {
            $departments = $this->departmentService->getAllDepartments();
        }

        if ($request->expectsJson()) {
            return response()->json($departments);
        }

        return view('departments.index', compact('departments'));
    }

    public function create()
    {
        $this->authorize('create', Department::class);

        $managers = $this->employeeService->getAllEmployees();

        return view('departments.create', compact('managers'));
    }

    public function store(StoreDepartmentRequest $request)
    {
        $this->authorize('create', Department::class);

        $department = $this->departmentService->createDepartment($request->validated());

        if ($request->expectsJson()) {
            return response()->json($department, 201);
        }

        return redirect()->route('departments.index')->with('success', 'تم إنشاء القسم بنجاح.');
    }

    public function show($id)
    {
        $department = $this->departmentService->getDepartmentById($id);

        $this->authorize('view', $department);

        return view('departments.show', compact('department'));
    }

    public function edit($id)
    {
        $department = $this->departmentService->getDepartmentById($id);

        $this->authorize('update', $department);

        $managers = $this->employeeService->getAllEmployees();

        return view('departments.edit', compact('department', 'managers'));
    }

    public function update(UpdateDepartmentRequest $request, $id)
    {
        $department = $this->departmentService->getDepartmentById($id);

        $this->authorize('update', $department);

        $this->departmentService->updateDepartment($id, $request->validated());

        if ($request->expectsJson()) {
            return response()->json($department);
        }

        return redirect()->route('departments.index')->with('success', 'تم تحديث القسم بنجاح.');
    }

    public function destroy(Request $request, $id)
    {
        $department = $this->departmentService->getDepartmentById($id);

        $this->authorize('delete', $department);

        $result = $this->departmentService->deleteDepartment($id);

        if (!$result) {
            return redirect()->route('departments.index')->with('error', 'لا يمكن حذف القسم لأنه يحتوي على موظفين.');
        }

        if ($request->expectsJson()) {
            return response()->json(['message' => 'تم حذف القسم بنجاح.']);
        }

        return redirect()->route('departments.index')->with('success', 'تم حذف القسم بنجاح.');
    }
}
