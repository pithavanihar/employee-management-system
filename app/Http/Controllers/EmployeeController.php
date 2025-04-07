<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Department;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $employees = Employee::with('department')->orderBy('id', 'desc')->paginate(10);
        return view('employees.index', compact('employees'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $departments = Department::where('status', 1)->get();
        return view('employees.create', compact('departments'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'department_id' => 'required|exists:departments,id',
            'name'          => 'required|string|max:255',
            'dob'           => 'required|date',
            'phone'         => 'required|string|max:20',
            'email'         => 'required|email|unique:employees,email',
            'salary'        => 'required|numeric|min:0',
            'status'        => 'required|in:0,1',
            'photo'         => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('employee_photos', 'public');
            $validated['photo'] = $photoPath;
        }

        $validated['created'] = now();
        $validated['modified'] = now();

        Employee::create($validated);

        return redirect()->route('employees.index')->with('success', 'Employee added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $employee = Employee::findOrFail($id);
        $departments = Department::where('status', 1)->get();
        return view('employees.edit', compact('employee', 'departments'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Employee $employee)
    {

        $request->validate([
            'department_id' => 'required|exists:departments,id',
            'name' => 'required|string|max:255',
            'dob' => 'required|date|before:today',
            'phone' => 'required|digits:10',
            'email' => 'required|email|unique:employees,email,' . $employee->id,
            'salary' => 'required|numeric|min:0',
            'status' => 'required|in:0,1',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        $data = $request->except('photo');
    
        // Handle photo upload
        if ($request->hasFile('photo')) {
            if ($employee->photo && \Storage::disk('public')->exists($employee->photo)) {
                \Storage::disk('public')->delete($employee->photo);
            }
        
            $photoPath = $request->file('photo')->store('employee_photos', 'public');
            $data['photo'] = $photoPath;
        }
    
        $employee->update($data);
    
        return redirect()->route('employees.index')->with('success', 'Employee updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        if ($employee->photo && \Storage::disk('public')->exists($employee->photo)) {
            \Storage::disk('public')->delete($employee->photo);
        }

        $employee->delete();

        return redirect()->route('employees.index')->with('success', 'Employee deleted successfully.');
    }

    public function toggleStatus(Request $request, Employee $employee)
    {
        $employee->status = !$employee->status;
        $employee->save();

        return response()->json([
            'success' => true,
            'new_status' => $employee->status ? 'Active' : 'Inactive',
        ]);
    }

}
