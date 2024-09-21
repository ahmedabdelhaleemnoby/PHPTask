<?php

namespace App\Http\Controllers;

use App\Services\TaskService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Models\Employee;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    protected $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    public function index(Request $request)
    {
        $tasks = $this->taskService->getAllTasks();

        if ($request->expectsJson()) {
            return response()->json($tasks);
        }

        return view('tasks.index', compact('tasks'));
    }

    public function create()
    {
        $employees = Employee::all();
        return view('tasks.create', compact('employees'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'employee_id' => 'required|exists:employees,id',
                'status' => 'required|in:pending,in-progress,completed',
            ]);

            $task = $this->taskService->createTask($request->all());

            if ($request->expectsJson()) {
                return response()->json($task, 201);
            }

            return redirect()->route('tasks.index');
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->validator)->withInput();
        }
    }

    public function edit($id)
    {
        $task = $this->taskService->getTaskById($id);

        if (Auth::user()->role !== 'admin' && $task->employee_id !== Auth::id()) {
            return redirect()->route('tasks.index')->with('error', 'You are not authorized to edit this task.');
        }

        $employees = Employee::all();
        return view('tasks.edit', compact('task', 'employees'));
    }

    public function update(Request $request, $id)
    {
        try {
            if (Auth::user()->role === 'employee') {
                $request->validate([
                    'status' => 'required|in:pending,in-progress,completed',
                ]);

                $task = $this->taskService->updateTask($id, ['status' => $request->status]);

            } else {
                $request->validate([
                    'title' => 'required|string|max:255',
                    'description' => 'nullable|string',
                    'employee_id' => 'required|exists:employees,id',
                    'status' => 'required|in:pending,in-progress,completed',
                ]);

                $task = $this->taskService->updateTask($id, $request->all());
            }

            if ($request->expectsJson()) {
                return response()->json($task);
            }

            return redirect()->route('tasks.index')->with('success', 'Task updated successfully.');
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->validator)->withInput();
        }
    }

    public function destroy(Request $request, $id)
    {
        $task = $this->taskService->getTaskById($id);

        if (Auth::user()->role !== 'admin' && $task->employee_id !== Auth::id()) {
            return redirect()->route('tasks.index')->with('error', 'You are not authorized to delete this task.');
        }

        $this->taskService->deleteTask($id);

        if ($request->expectsJson()) {
            return response()->json(['message' => 'Task deleted successfully.']);
        }

        return redirect()->route('tasks.index');
    }
}
