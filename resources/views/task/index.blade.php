@extends('layouts.main')

@section('content')
<div class="grid col-span-full">
    <h1 class="mb-5 max-w-2xl text-4xl md:text-4xl xl:text-5xl">{{ __('strings.tasks') }}</h1>

    
        <div>
            <a href="{{ route('tasks.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                {{ __('strings.created task') }}
            </a>
        </div>
    

    <table class="mt-4">
        <thead class="border-b-2 border-solid border-black text-left">
            <tr>
                <th>{{ __('strings.id') }}</th>
                <th>{{ __('strings.status') }}</th>
                <th>{{ __('strings.name') }}</th>
                <th>{{ __('strings.author') }}</th>
                <th>{{ __('strings.performer') }}</th>
                <th>{{ __('strings.data create') }}</th>
            </tr>
        </thead>
        <tbody>
            
        </tbody>
    </table>  
</div>
@endsection('content')