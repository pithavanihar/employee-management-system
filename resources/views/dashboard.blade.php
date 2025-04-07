@extends('layout')

@section('content')
<div class="container">
    <h2>Welcome, {{ auth()->user()->name }}</h2>

    <div class="mt-4 mb-4">
        <a href="{{ route('departments.index') }}" class="btn btn-primary">Manage Departments</a>
        <a href="{{ route('employees.index') }}" class="btn btn-success">Manage Employees</a>
    </div>

    <hr>

    <h4>Department-wise Highest Salary</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Department</th>
                <th>Employee</th>
                <th>Salary</th>
            </tr>
        </thead>
        <tbody>
            @foreach($highestSalaries as $row)
                <tr>
                    <td>{{ $row->department }}</td>
                    <td>{{ $row->employee }}</td>
                    <td>₹{{ number_format($row->salary, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <hr>

    <h4>Salary Range-wise Employee Count</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Range</th>
                <th>Count</th>
            </tr>
        </thead>
        <tbody>
            @foreach($salaryStats as $range => $count)
                <tr>
                    <td>{{ $range }}</td>
                    <td>{{ $count }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <hr>

    <h4>Youngest Employee per Department</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Department</th>
                <th>Employee</th>
                <th>Age</th>
                <th>Date of Birth</th>
            </tr>
        </thead>
        <tbody>
            @foreach($youngestEmployees as $row)
                <tr>
                    <td>{{ $row->department }}</td>
                    <td>{{ $row->employee }}</td>
                    <td>{{ $row->age }}</td>
                    <td>{{ \Carbon\Carbon::parse($row->dob)->format('d-m-Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
