<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\EmployeeTask;
use App\Models\Task;
use Illuminate\Http\Request;

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $records = Task::get();
        return response()->json(['success'=>true,'records'=>$records]);
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
          //
          $validated = $request->validate(['task_name'=>'required']);
          $record = Task::create($validated);
          if($record)
          {
              return response()->json(['success'=>true,'msg'=>'data saved succesfully']);
          }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        //
        $validated = $request->validate(['task_name'=>'required']);
        $record = $task->update($validated);
        if($record)
        {
            return response()->json(['success'=>true,'msg'=>'data updated succesfully']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        //
        $task->delete();
        return response()->json(['success'=>true,'msg'=>'task deleted succesfully']);
    }


    //assign task to employee
    public function assignTask(Request $request)
    {
        //assign single employee for task
        $record = EmployeeTask::create([
            'task_id'=>$request->task_id,
            'employee_id'=>$request->employee_id,
        ]);
        if($record)
        {
            return response()->json(['success'=>true,'msg'=>'assign employee saved success']);
        }
    }


    public function employeeTasks($employee_id)
    {
        $records = EmployeeTask::where('employee_id',$employee_id)->with('task')->get();
        return response()->json(['success'=>true,'data'=>$records]);

    }
}
