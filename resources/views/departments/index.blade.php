@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1>Departments</h1>

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(Auth::user()->role === 'admin')
        <a href="{{ route('departments.create') }}" class="btn btn-primary mb-3">Add New Department</a>
    @endif

    <table class="table table-bordered">
        <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Manager</th>
            <th>Employees Count</th>
            <th>Total Salary</th>
            @if(Auth::user()->role === 'admin')
                <th>Actions</th>
            @endif
        </tr>
        </thead>
        <tbody>
        @foreach ($departments as $department)
            <tr>
                <td>{{ $department->id }}</td>
                <td>{{ $department->name }}</td>
                <td>{{ $department->manager->first_name ?? 'No Manager' }}</td>
                <td>{{ $department->employees->count() }}</td>
                <td>{{ $department->employees->sum('salary') }}</td>
                @if(Auth::user()->role === 'admin')
                    <td>
                        <a href="{{ route('departments.edit', $department->id) }}" class="btn btn-primary">Edit</a>
                        <form action="{{ route('departments.destroy', $department->id) }}" method="POST" class="d-inline">
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
