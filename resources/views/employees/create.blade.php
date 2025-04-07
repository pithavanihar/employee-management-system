@extends('layout')

@section('content')
<div class="container mt-5">
    <h2>Add New Employee</h2>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form id="employeeForm" method="POST" action="{{ route('employees.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="department_id" class="form-label">Department</label>
            <select name="department_id" class="form-select" required>
                <option value="">Select Department</option>
                @foreach($departments as $department)
                    <option value="{{ $department->id }}" {{ old('department_id') == $department->id ? 'selected' : '' }}>
                        {{ $department->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Date of Birth</label>
            <input type="date" name="dob" class="form-control" value="{{ old('dob') }}" required max="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Phone</label>
            <input type="tel" name="phone" class="form-control" value="{{ old('phone') }}" required pattern="[0-9]{10}">
        </div>

        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Salary</label>
            <input type="number" name="salary" class="form-control" value="{{ old('salary') }}" required step="0.01" min="0">
        </div>

        <div class="mb-3">
            <label class="form-label">Status</label>
            <select name="status" class="form-select" required>
                <option value="1" {{ old('status') === '1' ? 'selected' : '' }}>Active</option>
                <option value="0" {{ old('status') === '0' ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Photo</label>
            <input type="file" name="photo" class="form-control" accept="image/*">
        </div>

        <button type="submit" class="btn btn-primary">Create Employee</button>
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
