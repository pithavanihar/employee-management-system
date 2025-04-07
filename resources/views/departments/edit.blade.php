@extends('layout')

@section('content')
<div class="container mt-4">
    <h1 class="mb-3">Edit Department</h1>

    <form action="{{ route('departments.update', $department->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Department Name</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $department->name) }}" required>
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" class="form-select" required>
                <option value="1" {{ old('status', $department->status) == '1' ? 'selected' : '' }}>Active</option>
                <option value="0" {{ old('status', $department->status) == '0' ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('departments.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection
