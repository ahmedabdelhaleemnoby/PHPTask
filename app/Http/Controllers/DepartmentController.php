<?php

namespace App\Http\Controllers;

use App\Services\DepartmentService;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;

class DepartmentController extends Controller
{
    protected $departmentService;

    public function __construct(DepartmentService $departmentService)
    {
        $this->departmentService = $departmentService;

        $this->middleware('auth');
        $this->middleware('role:admin')->only(['create', 'store', 'edit', 'update', 'destroy']);
    }

    public function index(Request $request)
    {
        if (Auth::user()->role === 'employee') {
            $departments = [$this->departmentService->getDepartmentById(Auth::user()->department_id)];
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
        $managers = Employee::all();
        return view('departments.create', compact('managers'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'manager_id' => 'nullable|exists:employees,id',
            ]);

            $department = $this->departmentService->createDepartment($request->all());

            if ($request->expectsJson()) {
                return response()->json($department, 201);
            }

            return redirect()->route('departments.index')->with('success', 'Department created successfully.');
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->validator)->withInput();
        }
    }

    public function edit($id)
    {
        $department = $this->departmentService->getDepartmentById($id);
        $managers = Employee::all();
        return view('departments.edit', compact('department', 'managers'));
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'manager_id' => 'nullable|exists:employees,id',
            ]);

            $department = $this->departmentService->updateDepartment($id, $request->all());

            if ($request->expectsJson()) {
                return response()->json($department);
            }

            return redirect()->route('departments.index')->with('success', 'Department updated successfully.');
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->validator)->withInput();
        }
    }

    public function destroy(Request $request, $id)
    {
        $result = $this->departmentService->deleteDepartment($id);

        if (isset($result['error'])) {
            return redirect()->route('departments.index')->with('error', $result['error']);
        }

        if ($request->expectsJson()) {
            return response()->json(['message' => 'Department deleted successfully.']);
        }

        return redirect()->route('departments.index')->with('success', 'Department deleted successfully.');
    }
}
