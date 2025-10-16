@extends('layouts.app')

@section('content')


    <div class="container mt-4">

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <h3>Create Task</h3>
        <form action="{{ route('familyOwner.tasks.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label>Title</label>
                <input type="text" placeholder="Title" name="title" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Type</label>
                <select name="type" class="form-control" required>
                    <option selected disabled>Select Task type</option>
                    <option value="medical">Medical</option>
                    <option value="non-medical">Non-Medical</option>
                </select>
            </div>
            <div class="mb-3">
                <label>Assign To</label>
                <select name="assignee_id" class="form-control" required>
                    <option selected disabled>Select user to Assign task</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label>Details</label>
                <textarea name="description" class="form-control">Details</textarea>
            </div>
            <button type="submit" class="btn btn-primary">Create</button>
        </form>
    </div>
@endsection
