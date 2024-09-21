<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Services\TaskService;
use App\Services\EmployeeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Task;

class TaskController extends Controller
{
    protected $taskService;
    protected $employeeService;

    public function __construct(TaskService $taskService, EmployeeService $employeeService)
    {
        $this->taskService = $taskService;
        $this->employeeService = $employeeService;

        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $this->authorize('viewAny', Task::class);

        $tasks = $this->taskService->getAllTasks();

        if ($request->expectsJson()) {
            return response()->json($tasks);
        }

        return view('tasks.index', compact('tasks'));
    }

    public function create()
    {
        $this->authorize('create', Task::class);

        $employees = $this->employeeService->getAllEmployees();

        return view('tasks.create', compact('employees'));
    }

    public function store(StoreTaskRequest $request)
    {
        $this->authorize('create', Task::class);

        $task = $this->taskService->createTask($request->validated());

        if ($request->expectsJson()) {
            return response()->json($task, 201);
        }

        return redirect()->route('tasks.index')->with('success', 'تم إنشاء المهمة بنجاح.');
    }

    public function show($id)
    {
        $task = $this->taskService->getTaskById($id);

        $this->authorize('view', $task);

        return view('tasks.show', compact('task'));
    }

    public function edit($id)
    {
        $task = $this->taskService->getTaskById($id);

        $this->authorize('update', $task);

        $employees = $this->employeeService->getAllEmployees();

        return view('tasks.edit', compact('task', 'employees'));
    }

    public function update(UpdateTaskRequest $request, $id)
    {
        $task = $this->taskService->getTaskById($id);

        $this->authorize('update', $task);

        $this->taskService->updateTask($id, $request->validated());

        if ($request->expectsJson()) {
            return response()->json($task);
        }

        return redirect()->route('tasks.index')->with('success', 'تم تحديث المهمة بنجاح.');
    }

    public function destroy(Request $request, $id)
    {
        $task = $this->taskService->getTaskById($id);

        $this->authorize('delete', $task);

        $this->taskService->deleteTask($id);

        if ($request->expectsJson()) {
            return response()->json(['message' => 'تم حذف المهمة بنجاح.']);
        }

        return redirect()->route('tasks.index')->with('success', 'تم حذف المهمة بنجاح.');
    }
}
