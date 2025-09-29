@extends('layouts.app')

@section('content')
<div class="container">
    <h3>{{ $vacation->title }}</h3>
    <p><strong>Type:</strong> {{ ucfirst($vacation->type) }}</p>
    <p><strong>Start Date:</strong> {{ \Carbon\Carbon::parse($vacation->start_date)->format('M d, Y') }}</p>
    <p><strong>End Date:</strong> {{ $vacation->end_date ? \Carbon\Carbon::parse($vacation->end_date)->format('M d, Y') : '-' }}</p>
    <p>{{ $vacation->description }}</p>

    <h5>Participants</h5>
    <ul>
        @foreach($vacation->users as $user)
            <li>{{ $user->name }} ({{ $user->custom_role ?? 'User' }})</li>
        @endforeach
    </ul>
</div>
@endsection