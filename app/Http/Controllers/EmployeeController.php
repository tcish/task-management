<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Traits\CurrentUserTrait;

class EmployeeController extends Controller
{
    use CurrentUserTrait;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = Task::select(['id', 'title', 'due_date', 'status', 'desc', 'created_by'])->with('createdBy:id,name')->where("created_by", $this->currentUserId())->get();

        return view('pages.index')->with("tasks", $tasks);
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
