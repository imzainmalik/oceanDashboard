@extends('layouts.app')

@section('content')
<div class="container">
    <h3>+ Schedule Meeting</h3>
    <form method="POST" action="{{ route('senior.meetings.store') }}">
        @csrf
        <div class="mb-3">
            <label>Topic</label>
            <input type="text" name="topic" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Agenda</label>
            <textarea name="agenda" class="form-control"></textarea>
        </div>
        <div class="mb-3">
            <label>Start Time</label>
            <input type="datetime-local" name="start_time" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Duration (minutes)</label>
            <input type="number" name="duration" class="form-control" value="30" required>
        </div>
        <button class="btn btn-success">Create</button>
    </form>
</div>
@endsection
