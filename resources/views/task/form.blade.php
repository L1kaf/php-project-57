{{ Form::label('name', __('strings.name')) }}
<div class="mt-2">
    {{ Form::text('name', $task->name, ['class' => 'rounded border-gray-300 w-1/3']) }}
</div>
@error('name')
    <div class="text-rose-600">
        {{ str_replace(':attribute', __('validation.attributes.task'), $message) }}
    </div>
@enderror
{{ Form::label('description', __('strings.description')) }}
<div class="mt-2">
    {{ Form::textarea('description', $task->description, ['class' => 'rounded border-gray-300 w-1/3', 'cols' => 50, 'rows' => 10]) }}
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
{{ Form::label('labels', __('strings.tags')) }}
<div class="mt-2">
    {{ Form::select('labels[]', $label, null, ['class' => 'rounded border-gray-300 w-1/3', 'multiple' => true, 'placeholder' => '']) }}
</div>
@error('labels')
    <div class="text-rose-600">
        {{ $message }}
    </div>
@enderror