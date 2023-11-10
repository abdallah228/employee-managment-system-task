<?php

namespace App\Http\Controllers\admin;

use App\Helpers\functions;
use App\Http\Controllers\Controller;
use App\Http\Requests\admin\EmployeeRequest;
use App\Http\Resources\admin\EmployeeResource;
use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $records = Employee::get();
        return response()->json(['success'=>'true','data'=>EmployeeResource::collection($records)]);
    }

    public function store(EmployeeRequest $request)
    {
        //
        $record = $request->validated();
        $record['image'] = functions::uploadMedia($request->image);

        $data = Employee::create($record);
        if($data)
        {
            return response()->json(['success'=>true,'msg'=>'record insert succesfully']);
        }
    }

    public function update(Request $request, Employee $employee)
    {
        //
        $data = $request->except('image');
        if($request->image)
        {
            $data['image'] = functions::uploadMedia($request->image);
        }

        $data = $employee->update($data);
        if($data)
        {
            return response()->json(['success'=>true,'msg'=>'record updated succesfully']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        //
        $employee->delete();
        return response()->json(['success'=>true,'msg'=>'record deleted succesfully']);
    }

    public function search(Request $request)
    {
        $keyword = $request->input('keyword');
        $minSalary = $request->input('min_salary');
        $maxSalary = $request->input('max_salary');
        $mangerName = $request->input('manger_name');

        $results = Employee::where(function ($query) use ($keyword) {
            $query->where('first_name', 'LIKE', "%$keyword%")
                ->orWhere('last_name', 'LIKE', "%$keyword%")
                ->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%$keyword%"]);
        })
        ->when($minSalary, function ($query) use ($minSalary) {
            $query->where('salary', '>=', $minSalary);
        })
        ->when($maxSalary, function ($query) use ($maxSalary) {
            $query->where('salary', '<=', $maxSalary);
        })
        ->when($mangerName, function ($query) use ($mangerName) {
            $query->where('manger_name', 'LIKE', "%$mangerName%");
        })
        ->get();

        return response()->json(['success'=>true,'data' => $results]);

    }
}
