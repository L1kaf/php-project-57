@extends('layouts.main')

@section('content')
<div class="grid col-span-full">
    <h1 class="mb-5 max-w-2xl text-4xl md:text-4xl xl:text-5xl">{{ __('strings.created task') }}</h1>
    {{ Form::model($task, ['route' => 'tasks.store']) }}
        <div class="flex flex-col">
            @include('task.form')       
            <div class="mt-2">
                {{ Form::submit((__('strings.created')), ['class' => 'bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded']) }}
            </div>
        </div>
    {{ Form::close() }}
</div>
@endsection('content')