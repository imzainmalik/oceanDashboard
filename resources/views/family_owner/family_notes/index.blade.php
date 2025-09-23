@extends('layouts.app')
@section('content')
    <div class="container py-4">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-3">
                        <h5>Family Notes & Feedback</h5>
                    </div>
                    <div class="col-9 d-flex justify-content-end">
                            <a href="{{ route('familyOwner.family-notes.create') }}" class="btn btn-primary">Add New</a>
                    </div>
                </div>
            </div>
            <div class="card-body"> 
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <table class="table">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Type</th>
                            <th>Visibility</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($notes->count() > 0)
                        @foreach ($notes as $note)
                            <tr>
                                <td>{{ $note->title }}</td>
                                <td>{{ ucfirst($note->type) }}</td>
                                <td>{{ ucfirst($note->visibility) }}</td>
                                <td>{{ $note->created_at->format('d M Y') }}</td>
                                <td>
                                    <a href="{{ route('familyOwner.family-notes.show', $note) }}"
                                        class="btn btn-info btn-sm">View</a>
                                    <a href="{{ route('familyOwner.family-notes.edit', $note) }}"
                                        class="btn btn-warning btn-sm">Edit</a>
                                    <form action="{{ route('familyOwner.family-notes.destroy', $note) }}" method="POST"
                                        style="display:inline-block">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-danger btn-sm"
                                            onclick="return confirm('Delete this note?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        @else
                            <tr>
                                <td>
                                    All notes will apprear here...
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>

                {{ $notes->links() }}
            </div>
        </div>
    </div>
@endsection
