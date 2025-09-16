@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3>Edit Task</h3>
    <form action="{{ route('familyOwner.tasks.update_task', $task->id) }}" method="post">
        @csrf
        <div class="mb-3">
            <label>Title</label>
            <input type="text" name="title" class="form-control" value="{{ $task->title }}" required>
        </div>
        <div class="mb-3">
            <label>Type</label>
            <select name="type" class="form-control" required>
                <option value="medical" @if($task->type == "medical") selected @endif>Medical</option>
                <option value="non-medical" @if($task->type == "non-medical") selected @endif>Non-Medical</option>
            </select>
        </div>
        <div class="mb-3">
            <label>Assign To</label>
            <select name="assignee_id" class="form-control" required>
                @foreach ($users as $user)
                    <option value="{{ $user->id }}" @if($task->assignee_id == $user->id) selected @endif>{{ $user->name }} ({{ $user->email }})</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label>Details</label>
            <textarea name="details" class="form-control">{{ $task->details }}</textarea>
        </div>
        <button type="submit" class="btn btn-success">Update</button>
    </form>
</div>
@endsection
