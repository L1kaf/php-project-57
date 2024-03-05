@extends('layouts.main')

@section('content')
<div class="grid col-span-full">
    <h1 class="mb-5 max-w-2xl text-4xl md:text-4xl xl:text-5xl">{{ __('strings.edit status') }}</h1>
    {{ Form::model($taskStatus, ['route' => ['task_statuses.update', $taskStatus], 'method' => 'PATCH']) }}
        <div class="flex flex-col">
            {{ Form::label('name', __('strings.name')) }}
            <div class="mt-2">
                {{ Form::text('name', $taskStatus->name, ['class' => 'rounded border-gray-300 w-1/3']) }}
            </div>
            @error('name')
                <div class="text-rose-600">
                    {{ $message }}
                </div>
            @enderror
            <div class="mt-2">
                {{ Form::submit((__('strings.refresh')), ['class' => 'bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded']) }}
            </div>
        </div>
    {{ Form::close() }}
</div>
@endsection('content')