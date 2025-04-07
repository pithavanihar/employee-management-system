@extends('layout')

@section('content')
<div class="container mt-5">
    <h2>Edit Employee</h2>

    {{-- Show validation errors --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form id="employeeForm" method="POST" action="{{ route('employees.update', $employee->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Department</label>
            <select name="department_id" class="form-select" required>
                <option value="">Select Department</option>
                @foreach($departments as $department)
                    <option value="{{ $department->id }}"
                        {{ old('department_id', $employee->department_id) == $department->id ? 'selected' : '' }}>
                        {{ $department->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text" name="name" value="{{ old('name', $employee->name) }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Date of Birth</label>
            <input type="date" name="dob" value="{{ old('dob', $employee->dob) }}" class="form-control" required max="{{ now()->format('Y-m-d') }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Phone</label>
            <input type="text" name="phone" value="{{ old('phone', $employee->phone) }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" value="{{ old('email', $employee->email) }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Salary</label>
            <input type="number" name="salary" value="{{ old('salary', $employee->salary) }}" class="form-control" required step="0.01" min="0">
        </div>

        <div class="mb-3">
            <label class="form-label">Status</label>
            <select name="status" class="form-select" required>
                <option value="1" {{ old('status', $employee->status) == 1 ? 'selected' : '' }}>Active</option>
                <option value="0" {{ old('status', $employee->status) == 0 ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Photo</label>
            <input type="file" name="photo" class="form-control" accept="image/*">
            @if ($employee->photo)
                <div class="mt-2">
                    <img src="{{ asset('storage/' . $employee->photo) }}" alt="Photo" width="100">
                </div>
            @endif
        </div>

        <button type="submit" class="btn btn-success">Update Employee</button>
    </form>
</div>
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function () {
    $('#employeeForm').on('submit', function (e) {
        let isValid = true;
        let phone = $('input[name="phone"]').val();
        let email = $('input[name="email"]').val();
        let salary = parseFloat($('input[name="salary"]').val());
        let dob = new Date($('input[name="dob"]').val());
        let today = new Date();
        today.setHours(0, 0, 0, 0);

        $('.error-message').remove();

        if (!/^\d{10}$/.test(phone)) {
            isValid = false;
            $('input[name="phone"]').after('<small class="text-danger error-message">Enter a valid 10-digit phone number.</small>');
        }

        if (!/^\S+@\S+\.\S+$/.test(email)) {
            isValid = false;
            $('input[name="email"]').after('<small class="text-danger error-message">Enter a valid email address.</small>');
        }

        if (isNaN(salary) || salary < 0) {
            isValid = false;
            $('input[name="salary"]').after('<small class="text-danger error-message">Salary must be a positive number.</small>');
        }

        if (dob >= today) {
            isValid = false;
            $('input[name="dob"]').after('<small class="text-danger error-message">Date of birth must be in the past.</small>');
        }

        if (!isValid) {
            e.preventDefault();
        }
    });
});
</script>
@endsection
