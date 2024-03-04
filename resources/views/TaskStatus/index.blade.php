@extends('layouts.main')

@section('content')
<div class="grid col-span-full">
    <h1 class="mb-5 max-w-2xl text-4xl md:text-4xl xl:text-5xl">{{ __('strings.statuses') }}</h1>

    <table class="mt-4">
        <thead class="border-b-2 border-solid border-black text-left">
            <tr>
                <th>{{ __('strings.id') }}</th>
                <th>{{ __('strings.name') }}</th>
                <th>{{ __('strings.data create') }}</th>
            </tr>
        </thead>
        <tbody>
        <tr class="border-b border-dashed text-left">
                <td>1</td>
                <td>новая</td>
                <td>04.03.2024</td>
            </tr>
        </tbody>
    </table>  
</div>
@endsection('content')