<!-- resources/views/employees/index.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Employees</h2>

    <!-- شريط البحث الشامل -->
    <form method="GET" action="{{ route('employees.index') }}">
        <div class="form-group">
            <input type="text" name="search" id="search" class="form-control" placeholder="Search by name, email, phone, etc." value="{{ request('search') }}">
        </div>
        <button type="submit" class="btn btn-primary">Search</button>
    </form>
    <div class="mb-3">
        <a href="{{ route('employees.create') }}" class="btn btn-success">Add Employee</a>
    </div>
    <!-- عرض نتائج البحث -->
    <table class="table mt-4">
        <thead>
            <tr>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Salary</th>
                <th>Manager</th>
                <th>Department</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($employees as $employee)
                <tr>
                    <td>{{ $employee->first_name }}</td>
                    <td>{{ $employee->last_name }}</td>
                    <td>{{ $employee->email }}</td>
                    <td>{{ $employee->phone }}</td>
                    <td>{{ $employee->salary }}</td>
                    <td>{{ optional($employee->manager)->first_name }} {{ optional($employee->manager)->last_name }}</td>
                    <td>{{ optional($employee->department)->name }}</td>
                    <td>
                        <a href="{{ route('employees.edit', $employee->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('employees.destroy', $employee->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
