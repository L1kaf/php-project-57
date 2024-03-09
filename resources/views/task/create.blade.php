@extends('layouts.main')

@section('content')
<div class="grid col-span-full">
    <h1 class="mb-5 max-w-2xl text-4xl md:text-4xl xl:text-5xl">{{ __('strings.created task') }}</h1>
    {{ Form::model($task, ['route' => 'tasks.store']) }}
        <div class="flex flex-col">
            {{ Form::label('name', __('strings.name')) }}
            <div class="mt-2">
                {{ Form::text('name', null, ['class' => 'rounded border-gray-300 w-1/3']) }}
            </div>
            @error('name')
                <div class="text-rose-600">
                    {{ $message }}
                </div>
            @enderror
            {{ Form::label('description', __('strings.description')) }}
            <div class="mt-2">
                {{ Form::textarea('description', null, ['class' => 'rounded border-gray-300 w-1/3', 'cols' => 50, 'rows' => 10]) }}
            </div>
            @error('description')
                <div class="text-rose-600">
                    {{ $message }}
                </div>
            @enderror
            {{ Form::label('status_id', __('strings.status')) }}
            <div class="mt-2">
                {{ Form::select('status_id', $taskStatus, null, ['class' => 'rounded border-gray-300 w-1/3', 'placeholder' => '----------']) }}
            </div>
            @error('status_id')
                <div class="text-rose-600">
                    {{ $message }}
                </div>
            @enderror
            {{ Form::label('assigned_to_id', __('strings.executor')) }}
            <div class="mt-2">
                {{ Form::select('assigned_to_id', $user, null, ['class' => 'rounded border-gray-300 w-1/3', 'placeholder' => '----------']) }}
            </div>
            @error('assigned_to_id')
                <div class="text-rose-600">
                    {{ $message }}
                </div>
            @enderror
            <div class="mt-2">
                {{ Form::submit((__('strings.created')), ['class' => 'bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded']) }}
            </div>
        </div>
    {{ Form::close() }}
</div>
@endsection('content')