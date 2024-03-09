@extends('layouts.main')

@section('content')
<div class="grid col-span-full">
    <h2 class="mb-5 text-3xl">{{ __('strings.view a task') }}: {{ $task->name }} <a href="/">&#9881;</a></h2>
    <p><span class="font-black">{{ __('strings.name') }}:</span> {{ $task->name }}</p>
    <p><span class="font-black">{{ __('strings.status') }}:</span> {{ $task->status->name }}</p>
    <p><span class="font-black">{{ __('strings.description') }}:</span> {{ $task->description }}</p>
</div>
@endsection('content')