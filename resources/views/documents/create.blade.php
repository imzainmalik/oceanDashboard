@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header">
            <h5>Create Emergency Document Request</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('document.requests.store') }}" method="POST">
                @csrf

                {{-- Target User --}}
                <div class="mb-3">
                    <label for="target_user_id" class="form-label">Select User to Request From</label>
                    <select name="target_user_id" id="target_user_id" class="form-select" required>
                        <option value="">-- Select User --</option>
                        @foreach($users as $user) 
                            <option value="{{ $user->users->id }}">{{ $user->users->name }} ({{ $user->users->email }})</option>
                        @endforeach
                    </select>
                </div>

                {{-- Title --}}
                <div class="mb-3">
                    <label for="title" class="form-label">Document Type</label>
                    <select name="doc_type" id="doc_type" class="form-select" required>
                        <option value="" selected disabled>-- Select Document Type --</option>
                         <option value="0">Regular Document</option>
                         <option value="1">Medical Document</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="title" class="form-label">Document Title</label>
                    <input type="text" class="form-control" name="title" id="title" placeholder="e.g. Emergency Medical Directive" required>
                </div>

                {{-- Message --}}
                <div class="mb-3">
                    <label for="message" class="form-label">Message / Instructions (Optional)</label>
                    <textarea class="form-control" name="message" id="message" rows="3" placeholder="Add any special instructions..."></textarea>
                </div>

                {{-- Deadline --}}
                <div class="mb-3">
                    <label for="deadline_minutes" class="form-label">Deadline (in minutes)</label>
                    <input type="number" name="deadline_minutes" id="deadline_minutes" class="form-control" value="60" min="5" max="10080" required>
                    <small class="text-muted">Set how long the user has to submit (5 mins – 7 days).</small>
                </div>

                {{-- Buttons --}}
                <div class="d-flex justify-content-end">
                    <a href="{{ route('document.requests.all') }}" class="btn btn-secondary me-2">Cancel</a>
                    <button type="submit" class="btn btn-primary">Create Request</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
