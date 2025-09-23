@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="card">
            <div class="card-header">
                <h5>{{ $familyNote->title }}</h5>
            </div>
            <div class="card-body">
                <div class="container">
                    <p><strong>Type:</strong> {{ ucfirst($familyNote->type) }}</p>
                    <p><strong>Visibility:</strong> {{ ucfirst($familyNote->visibility) }}</p>
                    <p>{{ $familyNote->content }}</p>
                    <a href="{{ route('familyOwner.family-notes.index') }}" class="btn btn-secondary">Back</a>
                </div>
            </div>
        </div>
    </div>
@endsection
