<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;
use App\Models\Label;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $taskStatuses = TaskStatus::select('name', 'id')->pluck('name', 'id');
        $users = User::select('name', 'id')->pluck('name', 'id');
        $tasks = QueryBuilder::for(Task::class)
            ->allowedFilters([
                'name',
                AllowedFilter::exact('status_id'),
                AllowedFilter::exact('created_by_id'),
                AllowedFilter::exact('assigned_to_id'),
            ])
            ->orderBy('id')
            ->paginate(15);

        return view('task.index', [
            'tasks' => $tasks,
            'users' => $users,
            'taskStatuses' => $taskStatuses,
            'activeFilter' => request()->get('filter', [
                'status_id' => '',
                'assigned_to_id' => '',
                'created_by_id' => ''
            ])]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $task = new Task();
        $taskStatus = TaskStatus::select('name', 'id')->pluck('name', 'id');
        $user = User::select('name', 'id')->pluck('name', 'id');
        $label = Label::select('name', 'id')->pluck('name', 'id');
        if (auth()->check()) {
            return view('task.create', compact('task', 'taskStatus', 'user', 'label'));
        }
        abort(403, 'This action is unauthorized.');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (auth()->check()) {
            $data = $this->validate(
                $request,
                [
                'name' => 'required|unique:tasks',
                'description' => '',
                'status_id' => 'required',
                'assigned_to_id' => ''
                ],
                [
                'unique' => __('validation.unique', ['attribute' => 'Задача']),
                ]
            );

            $labels = $request->input('labels', []);
            $user = auth()->user();
            if ($user !== null) {
                $data['created_by_id'] = $user->id;
            }
            $task = new Task();
            $task->fill($data);
            $task->save();
            $task->labels()->attach($labels);

            flash(__('messages.task.created'))->success();

            return redirect()->route('tasks.index');
        }
        abort(403, 'This action is unauthorized.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        $labels = $task->labels;
        return view('task.show', compact('task', 'labels'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $task = Task::findOrFail($id);
        $taskStatus = TaskStatus::select('name', 'id')->pluck('name', 'id');
        $user = User::select('name', 'id')->pluck('name', 'id');
        $label = Label::select('name', 'id')->pluck('name', 'id');
        if (auth()->check()) {
            return view('task.edit', compact('task', 'taskStatus', 'user', 'label'));
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
                'name' => 'required|unique:tasks,name,' . $task->id,
                'description' => '',
                'status_id' => 'required',
                'assigned_to_id' => ''
            ]);

            $labels = $request->input('labels', []);
            $task->fill($data);
            $task->save();
            $task->labels()->detach();
            $task->labels()->attach($labels);

            flash(__('messages.task.update'))->success();

            return redirect()->route('tasks.index');
        }
        abort(403, 'This action is unauthorized.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        if ($task->created_by_id === auth()->id()) {
            $task->delete();
            flash(__('messages.task.delete'))->success();

            return redirect()->route('tasks.index');
        }
        abort(403, 'This action is unauthorized.');
    }
}
