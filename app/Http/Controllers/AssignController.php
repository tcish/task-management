<?php

namespace App\Http\Controllers;

use App\Models\TaskAssignment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class AssignController extends Controller
{
    public function store(Request $request) {
        // Define the validation rules
        $rules = [
            'task-id' => 'required|string',
            'assign_to' => 'required|integer',
        ];

        // Create the validator instance
        $validator = Validator::make($request->all(), $rules);
        // Check if validation fails
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $params = $request->all();
        $task_id = base64_decode($params["task-id"]);
        TaskAssignment::create([
            "task_id" => $task_id,
            "assign_to" => $params["assign_to"],
        ]);

        Session::flash('success', 'Task assigned successfully!');

        return redirect()->route('tasks.index');
    }

    public function checkAssignee($task_id, $user_id) {
        $task_id = base64_decode($task_id);

        $hasAssign = TaskAssignment::where("task_id", $task_id)->where("assign_to", $user_id)->first();

        if (!empty($hasAssign)) {
            return response()->json(["status" => true, "message" => "This user is already assigned!"]);
        } else {
            return response()->json(["status" => false, "message" => ""]);
        }
    }
}
