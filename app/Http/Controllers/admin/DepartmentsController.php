<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $records = Department::get();
        return response()->json(['success'=>true,'records'=>$records]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validated = $request->validate(['department_name'=>'required']);
        $record = Department::create($validated);
        if($record)
        {
            return response()->json(['success'=>true,'msg'=>'data saved succesfully']);
        }

    }




    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Department $department)
    {
        //
        $validated = $request->validate(['department_name'=>'required']);
        $record = $department->update($validated);
        if($record)
        {
            return response()->json(['success'=>true,'msg'=>'data updated succesfully']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Department $department)
    {
        // Check if the department has employees
        $hasEmployees = $department->employees()->exists();

        if ($hasEmployees) {
            return response()->json(['error' => 'Cannot delete department with assigned employees.'], 422);
        }

        // If no employees, delete the department
        $department->delete();

        return response()->json(['msg' => 'Department deleted successfully']);
    }



    public function search(Request $request)
    {
        $department = Department::with('employees')
            ->where('department_name', $request->department_name)
            ->first();

        if (!$department) {
            return response()->json(['error' => 'Department not found.'], 404);
        }

        $employeeCount = $department->employees->count();
        $totalSalary = $department->employees->sum('salary');

        $result = [
            'department_name' => $department->name,
            'employee_count' => $employeeCount,
            'total_salary' => $totalSalary,
        ];

        return response()->json(['success'=>true,'record' => $result]);
    }

}
