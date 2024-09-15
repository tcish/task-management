<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use App\Traits\CurrentUserTrait;
use Illuminate\Support\Facades\Gate;

class TaskController extends Controller
{
    use CurrentUserTrait;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $currentUserId = $this->currentUserId();
        // ! here it's not making much difference but in bigger scenario specifying select can optimize load
        $tasks = Task::select(['tasks.id', 'tasks.title', 'tasks.due_date', 'tasks.status', 'tasks.desc', 'tasks.created_by'])
                    ->with('createdBy:id,name');

        if (!Gate::allows('is-admin')) {
            $tasks->where('created_by', $currentUserId)
                    ->orWhereIn('tasks.id', function ($subQuery) use ($currentUserId) {
                    // tasks assigned to the user
                    $subQuery->select('task_id')->from('task_assignments')->where('assign_to', $currentUserId);
                });
        }

        $tasks = $tasks->orderBy("tasks.id", "desc")->get();

        // for assign & permission users list
        $users = User::where("role", "employee")->get();

        return view("pages.index")->with("tasks", $tasks)->with("users", $users);
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
        if (Gate::denies('can_create')) {
            abort(403, 'Unauthorized action.');
        }

        // ? server-side validation taken care in TaskRequest
        $params = $request->all();
        $params["created_by"] = $this->currentUserId();
        // * no need all the fields to handle manually it will be handled by fillable
        Task::create($params);

        Session::flash('success', 'Task added successfully!');

        return redirect()->route('tasks.index');
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        if (Gate::denies('is-admin')) {
            abort(403, 'Unauthorized action.');
        }

        $id = base64_decode($id);
        $task = Task::select(['id', 'title', 'due_date', 'status', 'desc', 'created_by'])->where("id", $id)->get();

        return response()->json(["status" => true, "task" => $task]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TaskRequest $request, $id)
    {
        if (Gate::denies('is-admin')) {
            abort(403, 'Unauthorized action.');
        }

        $params = $request->all();
        $id = base64_decode($id);

        // Find the task by ID
        $task = Task::findOrFail($id);

        // Update the task with the validated data, respecting the fillable properties
        $task->update($params);

        Session::flash('success', 'Task updated successfully!');

        return redirect()->route('tasks.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $id = base64_decode($id);

        Task::where("id", $id)->delete();

        Session::flash('success', 'Task deleted successfully!');

        return redirect()->route('tasks.index');
    }

    public function markComplete($id) {
        $id = base64_decode($id);

        Task::where("id", $id)->update(["status" => "completed"]);

        Session::flash('success', 'Task mark as completed successfully!');

        return redirect()->route('tasks.index');
    }
}
