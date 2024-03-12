@extends('layouts.main')

@section('content')
<div class="grid col-span-full">
    <h1 class="mb-5 max-w-2xl text-4xl md:text-4xl xl:text-5xl">{{ __('strings.tags') }}</h1>

    @auth
        <div>
            <a href="{{ route('labels.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                {{ __('strings.created tag') }}
            </a>
        </div>
    @endauth

    <table class="mt-4">
        <thead class="border-b-2 border-solid border-black text-left">
            <tr>
                <th>{{ __('strings.id') }}</th>
                <th>{{ __('strings.name') }}</th>
                <th>{{ __('strings.description') }}</th>
                <th>{{ __('strings.data create') }}</th>
                @auth
                    <th>{{ __('strings.actions') }}</th>
                @endauth
            </tr>
        </thead>
        <tbody>
            @foreach ($labels as $label)
                <tr class="border-b border-dashed text-left">
                    <td>{{ $label->id }}</td>
                    <td>{{ $label->name }}</td>
                    <td>{{ $label->description }}</td>
                    <td>{{ $label->created_at->format('d.m.Y') }}</td>
                    @auth
                    <td>
                        <a href="{{ route('labels.destroy', $label->id) }}" data-method="delete" data-confirm="{{ __('strings.are you sure?') }}" class="text-red-600 hover:text-red-900">{{ __('strings.delete') }}</a>
                        <a class="text-blue-600 hover:text-blue-900" href="{{ route('labels.edit', $label->id) }}">{{ __('strings.edit') }}</a>  
                    </td>
                    @endauth
                </tr>
            @endforeach
        </tbody>
    </table>  
</div>
@endsection('content')