@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        {{-- Task Details --}}
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <h3 class="card-title">{{ $task->title }}</h3>
                <p><strong>Type:</strong>
                    <span class="badge bg-{{ $task->type === 'medical' ? 'danger' : 'info' }}">
                        {{ ucfirst($task->type) }}
                    </span>
                </p>
                <p><strong>Status:</strong>
                    <span class="badge bg-secondary">{{ ucfirst($task->status) }}</span>
                </p>
                <p><strong>Owner:</strong> {{ $task->owner->name }}</p>
                <p><strong>Assignee:</strong> {{ $task->assignee->name }}</p>
                <p><strong>Details:</strong> {{ $task->details }}</p>
            </div>
        </div>

        {{-- Comments Section --}}

        @php
            // ensure defaults
            $level = $level ?? 0;
            // Decide who can comment: super admin (role name may be 'super_admin') OR assignee.
            $user = auth()->user();
            $roleName = $user->role->name ?? null;
            $canComment = $roleName === 'familyOwner' || $user->id === $task->assignee_id;
            // dd($canComment);
        @endphp


        {{-- Comments --}}
        <div class="card shadow-sm">
            <div class="card-header bg-light">
                <h5 class="mb-0">Comments</h5>
            </div>

            <div class="card-body" style="max-height: 400px; overflow-y:auto;">
                @forelse ($task->comments->where('parent_id', 0) as $comment)
                    @include('components.comment', [
                        'comment' => $comment,
                        'task' => $task,
                        'level' => 0,
                    ])
                @empty
                    <p class="text-muted">No comments yet.</p>
                @endforelse
            </div>

            {{-- Root comment form (Admin + Assignee only) --}}
            @php
                $user = auth()->user();
                $role = $user->role->name ?? null;
                $canComment = $role === 'familyOwner' || $role === 'familyOwner' || $user->id === $task->assignee_id;
            @endphp

            @if ($canComment)
                <div class="card-footer">
                    <form action="{{ route('familyOwner.tasks.comment.store', $task->id) }}" method="POST">
                        @csrf
                        <div class="input-group">
                            <input type="text" name="message" class="form-control" placeholder="Write a comment..."
                                required>
                            <button class="btn btn-primary">Send</button>
                        </div>
                    </form>
                </div>
            @else
                <div class="card-footer text-muted">Only Family owner and Assignee can comment.</div>
            @endif
        </div>
    </div>
@endsection

@push('js')
    <script>
        function toggleReplyForm(id) {
            let form = document.getElementById('reply-form-' + id);
            form.classList.toggle('d-none');
        }
    </script>
@endpush
