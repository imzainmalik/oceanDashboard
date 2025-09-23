@extends('layouts.app')
@section('content')

{{-- @dd($voting); --}}
<div class="container">
    @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    <h3>{{ isset($voting) ? 'Edit' : 'Create' }} Voting Pool</h3>

    <form action="{{ isset($voting) ? route('familyOwner.pools.update', $voting->id) : route('familyOwner.pools.store') }}" method="POST">
        @csrf
        @if(isset($voting)) @method('PUT') @endif

        <div class="mb-3">
            <label>Title</label>
            <input name="title" class="form-control" value="{{ old('title', $voting->title ?? '') }}" required>
        </div>

        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control">{{ old('description', $voting->description ?? '') }}</textarea>
        </div>

        <div class="mb-3">
            <label>Voting expiry (optional)</label>
            <input type="datetime-local" name="voting_expires_at" class="form-control"
                   value="{{ isset($voting) && $voting->voting_expires_at ? $voting->voting_expires_at->format('Y-m-d\TH:i') : '' }}">
        </div>

        <button class="btn btn-success">Save</button>
    </form>
</div>
@endsection
