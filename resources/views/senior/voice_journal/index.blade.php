@extends('layouts.app')

@section('content')
<div class="container">
    <h3>🎤 My Voice Journal</h3>
    <a href="{{ route('senior.voice-journal.create') }}" class="btn btn-primary mb-3">+ New Voice Note</a>

    @forelse($journals as $journal)
        <div class="card mb-3">
            <div class="card-body">
                <h5>{{ $journal->title ?? 'Voice Note' }}</h5>
                <audio controls>
                    <source src="{{ asset('storage/'.$journal->file_path) }}" type="audio/mpeg">
                    Your browser does not support the audio element.
                </audio>
                <p class="text-muted mt-2">Added on {{ $journal->created_at->format('d M, Y h:i A') }}</p>
            </div>
        </div>
    @empty
        <p>No voice journals yet.</p>
    @endforelse
</div>
@endsection
