<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TaskStatus;
use App\Http\Requests\UpdateTaskStatusRequest;

class TaskStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $taskStatuses = TaskStatus::orderBy('id')->get();
        return view('TaskStatus.index', compact('taskStatuses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $taskStatus = new TaskStatus();
        if (auth()->check()) {
            return view('TaskStatus.create', compact('taskStatus'));
        }
        abort(403, 'This action is unauthorized.');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $this->validate($request, [
            'name' => 'required|unique:task_statuses',
        ]);

        $taskStatus = new TaskStatus();
        $taskStatus->fill($data);
        $taskStatus->save();

        flash(__('messages.status.created'))->success();

        return redirect()->route('task_statuses.index');
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
        $taskStatus = TaskStatus::findOrFail($id);
        if (auth()->check()) {
            return view('TaskStatus.edit', compact('taskStatus'));
        }
        abort(403, 'This action is unauthorized.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $taskStatus = TaskStatus::findOrFail($id);

        $data = $request->validate([
            'name' => 'required|unique:task_statuses',
        ]);

        $taskStatus->fill($data);
        $taskStatus->save();

        flash(__('messages.status.update'))->success();
        return redirect()->route('task_statuses.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $taskStatus = TaskStatus::find($id);
        if ($taskStatus) {
            $taskStatus->delete();
        }

        return redirect()->route('task_statuses.index');
    }
}
