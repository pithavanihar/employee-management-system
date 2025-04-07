<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Department;
use App\Models\Employee;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $departments = Department::all();
        return view('departments.index', compact('departments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('departments.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|boolean',
        ]);
    
        Department::create([
            'name' => $request->name,
            'status' => $request->status,
            'created' => now(),
            'modified' => now(),
        ]);
    
        return redirect()->route('departments.index')->with('success', 'Department created!');
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
        $department = Department::findOrFail($id);
        return view('departments.edit', compact('department'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|boolean',
        ]);
    
        $department = Department::findOrFail($id);
        $department->update([
            'name' => $request->name,
            'status' => $request->status,
            'modified' => now(),
        ]);
    
        return redirect()->route('departments.index')->with('success', 'Department updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $department = Department::findOrFail($id);

        $employeeCount = Employee::where('department_id', $id)->count();
        if ($employeeCount > 0) {
            return redirect()->route('departments.index')->with('error', 'Department cannot be deleted — employees exist.');
        }
    
        $department->delete();
        return redirect()->route('departments.index')->with('success', 'Department deleted!');
    }
}
