@extends('layout')

@section('content')
<div class="container">
    <h2>Employee List</h2>
    <a href="{{ route('employees.create') }}" class="btn btn-primary mb-3">Add Employee</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Photo</th>
                <th>Name</th>
                <th>Department</th>
                <th>Email</th>
                <th>Phone</th>
                <th>DOB</th>
                <th>Salary</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        @forelse ($employees as $employee)
            <tr>
                <td>
                    @if($employee->photo)
                        <img src="{{ asset('storage/' . $employee->photo) }}" width="60" height="60" style="object-fit: cover;">
                    @else
                        N/A
                    @endif
                </td>
                <td>{{ $employee->name }}</td>
                <td>{{ $employee->department->name ?? 'N/A' }}</td>
                <td>{{ $employee->email }}</td>
                <td>{{ $employee->phone }}</td>
                <td>{{ $employee->dob }}</td>
                <td>₹{{ number_format($employee->salary, 2) }}</td>
                <td>
                    <button class="btn btn-sm toggle-status-btn {{ $employee->status ? 'btn-success' : 'btn-secondary' }}"
                            data-id="{{ $employee->id }}">
                        {{ $employee->status ? 'Active' : 'Inactive' }}
                    </button>
                </td>
                <td>
                    <a href="{{ route('employees.edit', $employee->id) }}" class="btn btn-warning btn-sm">Edit</a>

                    <form action="{{ route('employees.destroy', $employee->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure to delete this employee?');">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="9" class="text-center">No employees found.</td>
            </tr>
        @endforelse
        </tbody>
    </table>
    <div class="mt-4">
        {{ $employees->links() }}
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        $('.toggle-status-btn').on('click', function () {
            let button = $(this);
            let employeeId = button.data('id');

            $.ajax({
                url: '/employees/' + employeeId + '/toggle-status',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function (response) {
                    if (response.success) {
                        let newStatus = response.new_status;
                        button.text(newStatus);
                        button.toggleClass('btn-success btn-secondary');
                    }
                },
                error: function () {
                    alert('Something went wrong!');
                }
            });
        });
    });
</script>
@endsection
