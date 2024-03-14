@extends('layouts.main')

@section('content')
<div class="grid col-span-full">
    <h1 class="mb-5 max-w-2xl text-4xl md:text-4xl xl:text-5xl">{{ __('strings.edit task') }}</h1>
    {{ Form::model($task, ['route' => ['tasks.update', $task], 'method' => 'PATCH']) }}
        <div class="flex flex-col">
            @include('task.form')       
            <div class="mt-2">
                {{ Form::submit((__('strings.refresh')), ['class' => 'bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded']) }}
            </div>
        </div>
    {{ Form::close() }}
</div>
@endsection('content')