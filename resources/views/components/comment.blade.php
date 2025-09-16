@php
    $margin = $level * 20; // indentation for replies
@endphp

<div class="mb-3" style="margin-left: {{ $margin }}px;">
    <div class="p-2 border rounded bg-white">
        <div class="d-flex justify-content-between">
            <strong>{{ $comment->user->name }}</strong>
            <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
        </div>
        <p class="mb-1">{{ $comment->message }}</p>

        @php
            $user = auth()->user();
            $role = $user->role->name ?? null;
            $canReply = $role === 'familyOwner' || $role === 'familyOwner' || $user->id === $task->assignee_id;
        @endphp

        @if ($canReply)
            <a href="javascript:void(0)" onclick="toggleReplyForm({{ $comment->id }})" class="small">Reply</a>

            <form id="reply-form-{{ $comment->id }}" class="d-none mt-2"
                action="{{ route('familyOwner.tasks.comment.store', $task->id) }}" method="POST">
                @csrf
                <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                <div class="input-group">
                    <input type="text" name="message" class="form-control form-control-sm"
                        placeholder="Write a reply..." required>
                    <button class="btn btn-sm btn-primary">Send</button>
                </div>
            </form>
        @endif
    </div>

    {{-- Recursive replies --}}
    @foreach ($comment->replies as $reply)
        @include('components.comment', ['comment' => $reply, 'task' => $task, 'level' => $level + 1])
    @endforeach
</div>
