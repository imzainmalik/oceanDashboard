@props(['comment', 'level' => 0])
<div class="mb-2" style="margin-left: {{ $level * 20 }}px;">
    <div class="p-2 border rounded">
        <div class="d-flex justify-content-between">
            <strong>{{ $comment->user->name }}</strong>
            <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
        </div>
        <p class="mb-1">{{ $comment->message }}</p>

        <a href="javascript:void(0)" onclick="toggleReply({{ $comment->id }})">Reply</a>
        <form id="reply-form-{{ $comment->id }}" class="d-none mt-2" method="POST"
            action="{{ route('familyOwner.voting.comment.store', $comment->pool_id) }}">
            @csrf
            <input type="hidden" name="parent_id" value="{{ $comment->id }}">
            <div class="input-group">
                <input name="message" class="form-control form-control-sm" placeholder="Write a reply..." required>
                <button class="btn btn-sm btn-primary">Send</button>
            </div>
        </form>
    </div>

    @foreach ($comment->replies as $reply)
        @include('voting.partials.comment', ['comment' => $reply, 'level' => $level + 1])
    @endforeach
</div>

@push('js')
    <script>
        function toggleReply(id) {
            var el = document.getElementById('reply-form-' + id);
            if (el) el.classList.toggle('d-none');
        }
    </script>
@endpush
