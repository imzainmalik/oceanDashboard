@extends('layouts.app')

@section('content')
<div class="container">
    <h3>📅 My Meetings</h3>
    <a href="{{ route(''.auth()->user()->custom_role.'.meetings.create') }}" class="btn btn-primary mb-3">Schedule Meeting</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Topic</th>
                <th>Start Time</th>
                <th>Status</th>
                <th>Links</th>
                <th>IsActive</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($meetings as $meeting)
            <tr>
                <td>{{ $meeting->topic }}</td>
                <td>{{ \Carbon\Carbon::parse($meeting->start_time)->format('d M, Y h:i A') }}</td>
                <td><span class="badge bg-info">{{ ucfirst($meeting->status) }}</span></td>
                <td>
                    <a href="{{ $meeting->join_url }}" target="_blank" class="btn btn-sm btn-success">Join</a>
                </td>
                <td>
                     @if($meeting->is_active == 0)
                           <span class="badge bg-success">Active Meeting</span>
                     @else
                           <span class="badge bg-danger">InActive Meeting</span>
                    @endif     
                </td>
                <td>
                    <a href="{{ route(''.auth()->user()->custom_role.'.meetings.edit',$meeting->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route(''.auth()->user()->custom_role.'.meetings.destroy',$meeting->id) }}" method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger">Active / InActive Meeting</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
