@extends('layouts.app')

@section('content')
<div class="container">
    <h2>{{ isset($familyNote) ? 'Edit Note' : 'Add Note' }}</h2>

    <form method="POST" action="{{ isset($familyNote) ? route(''.auth()->user()->custom_role.'.family-notes.update', $familyNote) : route(''.auth()->user()->custom_role.'.family-notes.store') }}">
        @csrf
        {{-- @if(isset($familyNote))
            @method('PUT')
        @endif --}}

        <div class="form-group mb-3">
            <label>Title</label>
            <input type="text" name="title" class="form-control" value="{{ old('title', $familyNote->title ?? '') }}" required>
        </div>

        <div class="form-group mb-3">
            <label>Content</label>
            <textarea name="content" class="form-control" rows="5" required>{{ old('content', $familyNote->content ?? '') }}</textarea>
        </div>

        <div class="form-group mb-3">
            <label>Type</label>
            <select name="type" class="form-control">
                <option value="note" {{ old('type', $familyNote->type ?? '')=='note'?'selected':'' }}>Note</option>
                <option value="feedback" {{ old('type', $familyNote->type ?? '')=='feedback'?'selected':'' }}>Feedback</option>
            </select>
        </div>

        {{-- <div class="form-group mb-3">
            <label>Visibility</label>
            <select name="visibility" class="form-control">
                <option value="family" {{ old('visibility', $familyNote->visibility ?? '')=='family'?'selected':'' }}>Family</option>
                <option value="private" {{ old('visibility', $familyNote->visibility ?? '')=='private'?'selected':'' }}>Private</option>
            </select>
        </div> --}}

        <button type="submit" class="btn btn-primary">{{ isset($familyNote) ? 'Update' : 'Save' }}</button>
        <a href="{{ route(''.auth()->user()->custom_role.'.family-notes.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
