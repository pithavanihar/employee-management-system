@extends('layout')

@section('content')
<div class="container mt-4">
    <h1 class="mb-3">Departments</h1>

    <a href="{{ route('departments.create') }}" class="btn btn-primary mb-3">+ Add Department</a>

    @if($departments->count())
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($departments as $department)
            <tr>
                <td>{{ $department->id }}</td>
                <td>{{ $department->name }}</td>
                <td>{{ $department->status ? 'Active' : 'Inactive' }}</td>
                <td>
                    <a href="{{ route('departments.edit', $department->id) }}" class="btn btn-sm btn-warning">Edit</a>

                    <form action="{{ route('departments.destroy', $department->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <div class="alert alert-info">No departments found.</div>
    @endif
</div>
@endsection
