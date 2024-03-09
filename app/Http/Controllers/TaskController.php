<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = Task::orderBy('id')->get();
        return view('task.index', compact('tasks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $task = new Task();
        $taskStatus = TaskStatus::select('name', 'id')->pluck('name', 'id');
        $user = User::select('name', 'id')->pluck('name', 'id');
        if (auth()->check()) {
            return view('task.create', compact('task', 'taskStatus', 'user'));
        }
        abort(403, 'This action is unauthorized.');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (auth()->check()) {
            $data = $this->validate($request, [
                'name' => 'required|unique:task_statuses',
                'description' => '',
                'status_id' => 'required',
                'assigned_to_id' => ''
            ]);

            $data['created_by_id'] = auth()->user()->id;
            $task = new Task();
            $task->fill($data);
            $task->save();

            flash(__('messages.task.created'))->success();

            return redirect()->route('tasks.index');
        }
        abort(403, 'This action is unauthorized.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $task = Task::findOrFail($id);
        return view('task.show', compact('task'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $task = Task::findOrFail($id);
        $taskStatus = TaskStatus::select('name', 'id')->pluck('name', 'id');
        $user = User::select('name', 'id')->pluck('name', 'id');
        if (auth()->check()) {
            return view('task.edit', compact('task', 'taskStatus', 'user'));
        }
        abort(403, 'This action is unauthorized.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if (auth()->check()) {
            $task = Task::findOrFail($id);
            $data = $this->validate($request, [
                'name' => 'required|unique:task_statuses',
                'description' => '',
                'status_id' => 'required',
                'assigned_to_id' => ''
            ]);

            $task->fill($data);
            $task->save();

            flash(__('messages.task.update'))->success();

            return redirect()->route('tasks.index');
        }
        abort(403, 'This action is unauthorized.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $task = Task::find($id);
        if ($task->created_by_id === auth()->id()) { 
                $task->delete();
                flash(__('messages.task.delete'))->success();

            return redirect()->route('tasks.index');
        }
        abort(403, 'This action is unauthorized.');
    }
}
