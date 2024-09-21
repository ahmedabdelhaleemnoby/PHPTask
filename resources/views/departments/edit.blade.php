<!-- resources/views/departments/edit.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Department</h2>
    <form action="{{ route('departments.update', $department->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Department Name:</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $department->name) }}" required>
            @error('name')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="manager_id">Manager:</label>
            <select name="manager_id" id="manager_id" class="form-control">
                <option value="">No Manager</option>
                @foreach($managers as $manager)
                    <option value="{{ $manager->id }}" {{ old('manager_id', $department->manager_id) == $manager->id ? 'selected' : '' }}>
                        {{ $manager->first_name }} {{ $manager->last_name }}
                    </option>
                @endforeach
            </select>
            @error('manager_id')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Update Department</button>
    </form>
</div>
@endsection
