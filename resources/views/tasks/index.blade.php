@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1>Tasks</h1>

    @if(Auth::user()->role === 'admin')
        <a href="{{ route('tasks.create') }}" class="btn btn-primary mb-3">Add New Task</a>
    @endif

    <table class="table table-bordered">
        <thead>
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Description</th>
            <th>Status</th>
            <th>Employee</th>
            @if(Auth::user()->role === 'admin')
                <th>Actions</th>
            @endif
        </tr>
        </thead>
        <tbody>
        @foreach ($tasks as $task)
            <tr>
                <td>{{ $task->id }}</td>
                <td>{{ $task->title }}</td>
                <td>{{ $task->description }}</td>
                <td>
                    @if(Auth::id() === $task->employee_id)
                        <!-- إذا كان المستخدم هو الموظف، يتم عرض قائمة منسدلة لتغيير الحالة -->
                        <form action="{{ route('tasks.update', $task->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <select name="status" onchange="this.form.submit()">
                                <option value="pending" {{ $task->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="in-progress" {{ $task->status == 'in-progress' ? 'selected' : '' }}>In Progress</option>
                                <option value="completed" {{ $task->status == 'completed' ? 'selected' : '' }}>Completed</option>
                            </select>
                        </form>
                    @else
                        <!-- إذا لم يكن المستخدم هو الموظف، يتم عرض الحالة فقط -->
                        {{ $task->status }}
                    @endif
                </td>
                <td>{{ $task->employee->first_name }} {{ $task->employee->last_name }}</td>
                @if(Auth::user()->role === 'admin')
                    <td>
                        <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-primary">Edit</a>
                        <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                @endif
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
