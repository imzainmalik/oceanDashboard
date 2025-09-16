@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3>Create Task</h3>
    <form action="{{ route('familyOwner.tasks.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Title</label>
            <input type="text" name="title" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Type</label>
            <select name="type" class="form-control" required>
                <option value="medical">Medical</option>
                <option value="non-medical">Non-Medical</option>
            </select>
        </div>
        <div class="mb-3">
            <label>Assign To</label>
            <select name="assignee_id" class="form-control" required>
                @foreach ($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label>Details</label>
            <textarea name="details" class="form-control"></textarea>
        </div>
        <button type="submit" class="btn btn-success">Create</button>
    </form>
</div>
@endsection
