<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // ! here it's not making much difference but in bigger scenario specifying select can optimize load
        $tasks = Task::select(['id', 'title', 'due_date', 'status', 'desc', 'created_by'])->with('createdBy:id,name')->get();

        return view("pages.admin.index")->with("tasks", $tasks);
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
    public function store(TaskRequest $request)
    {
        // ? server-side validation taken care in TaskRequest
        $params = $request->all();
        $params["created_by"] = Auth::user()->id;
        // * no need all the fields to handle manually it will be handled by fillable
        Task::create($params);

        Session::flash('success', 'Task added successfully!');

        return redirect()->route('tasks.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        //
    }
}
