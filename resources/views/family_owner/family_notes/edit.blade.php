@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="card">
            <div class="card-header">
                <h5>{{ isset($familyNote) ? 'Edit Note' : 'Add Note' }}</h5>
            </div>
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form method="POST"
                    action="{{ isset($familyNote) ? route('familyOwner.family-notes.update', $familyNote) : route('family-notes.store') }}">
                    @csrf
                    @if (isset($familyNote))
                        @method('PUT')
                    @endif

                    <div class="form-group mb-3">
                        <label>Title</label>
                        <input type="text" name="title" class="form-control"
                            value="{{ old('title', $familyNote->title ?? '') }}" required>
                    </div>

                    <div class="form-group mb-3">
                        <label>Content</label>
                        <textarea name="content" class="form-control" rows="5" required>{{ old('content', $familyNote->content ?? '') }}</textarea>
                    </div>

                    <div class="form-group mb-3">
                        <label>Type</label>
                        <select name="type" class="form-control">
                            <option value="note" {{ old('type', $familyNote->type ?? '') == 'note' ? 'selected' : '' }}>
                                Note
                            </option>
                            <option value="feedback"
                                {{ old('type', $familyNote->type ?? '') == 'feedback' ? 'selected' : '' }}>
                                Feedback
                            </option>
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label>Visibility</label>
                        <select name="visibility" class="form-control">
                            <option value="family"
                                {{ old('visibility', $familyNote->visibility ?? '') == 'family' ? 'selected' : '' }}>
                                Family</option>
                            <option value="private"
                                {{ old('visibility', $familyNote->visibility ?? '') == 'private' ? 'selected' : '' }}>
                                Private</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-success">{{ isset($familyNote) ? 'Update' : 'Save' }}</button>
                    <a href="{{ route('familyOwner.family-notes.index') }}" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
@endsection
