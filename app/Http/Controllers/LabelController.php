<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Label;

class LabelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $labels = label::orderBy('id')->get();
        return view('label.index', compact('labels'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $label = new Label();
        if (auth()->check()) {
            return view('label.create', compact('label'));
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
                'name' => 'required|unique:labels',
                'description' => ''
            ]);

            $label = new Label();
            $label->fill($data);
            $label->save();

            flash(__('messages.tag.created'))->success();

            return redirect()->route('labels.index');
        }
        abort(403, 'This action is unauthorized.');
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
        $label = Label::findOrFail($id);
        if (auth()->check()) {
            return view('label.edit', compact('label'));
        }
        abort(403, 'This action is unauthorized.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if (auth()->check()) {
            $lable = Label::findOrFail($id);

            $data = $this->validate($request, [
                'name' => 'required|unique:labels,name,' . $lable->id,
                'description' => ''
            ]);

            $lable->fill($data);
            $lable->save();

            flash(__('messages.tag.update'))->success();
            return redirect()->route('labels.index');
        }
        abort(403, 'This action is unauthorized.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (auth()->check()) {
            $label = label::find($id);
            if ($label->tasks()->exists()) {
                flash(__('messages.tag.error'))->error();
            } else {
                $label->delete();
                flash(__('messages.tag.delete'))->success();
            }

            return redirect()->route('labels.index');
        }
        abort(403, 'This action is unauthorized.');
    }
}
