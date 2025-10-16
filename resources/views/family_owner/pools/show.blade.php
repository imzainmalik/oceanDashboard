@extends('layouts.app')
@section('content')
    <div class="container">
        {{-- <a href="{{ route('familyOwner.pools.index') }}" class="btn btn-sm btn-secondary mb-2">Back</a> --}}
        {{-- @dd($voting->id); --}}
        <div class="card mb-3">
            <div class="card-body">
                <h4>{{ $voting->title }}</h4>
                <p class="text-muted">Created by: {{ $voting->owner->name }}</p>
                <p>{{ $voting->description }}</p>
                <div>
                    <strong>Status:</strong> <span class="badge bg-info">{{ $voting->status }}</span>
                    @if ($voting->voting_expires_at)
                        <span class="ms-3">Expires: {{ $voting->voting_expires_at->toDayDateTimeString() }}</span>
                    @endif
                </div>
                @if ($voting->status == 'final_decision')
                    <div class="mt-2 alert alert-primary">
                        <strong>Final Decision by {{ $voting->finalDecisionBy?->name ?? 'N/A' }}:</strong>
                        <div>{!! nl2br(e($voting->final_decision_notes)) !!}</div>
                    </div>
                @endif
            </div>
        </div>

        {{-- Vote summary --}}
        @php $counts = $voting->counts(); @endphp
        <div class="mb-3">
            <span class="badge bg-success">YES: {{ $counts['yes'] }}</span>
            <span class="badge bg-danger ms-2">NO: {{ $counts['no'] }}</span>
            <span class="badge bg-secondary ms-2">ABSTAIN: {{ $counts['abstain'] }}</span>
            <span class="badge bg-dark ms-2">TOTAL: {{ $counts['total'] }}</span>
        </div>

        {{-- Vote form --}}
        @if ($voting->isOpen())
            <div class="card mb-3">
                <div class="card-body">
                    <form method="POST" action="{{ route(''.auth()->user()->custom_role.'.voting.vote', $voting->id) }}">
                        @csrf
                        <div class="mb-2">
                            <label>Choice</label>
                            <select name="choice" class="form-control" required>
                                <option value="yes">Yes</option>
                                <option value="no">No</option>
                                <option value="abstain">Abstain</option>
                            </select>
                        </div>
                        <div class="mb-2">
                            <label>Comment (optional)</label>
                            <input type="text" name="comment" class="form-control">
                        </div>
                        <button class="btn btn-primary">Submit Vote</button>
                    </form>
                </div>
            </div>
        @else
            <div class="alert alert-secondary">Voting is closed.</div>
        @endif
        {{-- @dd($voting); --}}
        {{-- Votes list --}}
        @php
            $pool = $voting;
        @endphp
        <div class="card mb-3">
            <div class="card-header">Votes</div>
            <div class="card-body">
                @forelse($voting->votes as $vote)
                    <div class="mb-2 p-2 border rounded">
                        <strong>{{ $vote->user->name }}</strong>
                        <span
                            class="badge bg-{{ $vote->choice === 'yes' ? 'success' : ($vote->choice === 'no' ? 'danger' : 'secondary') }} ms-2">
                            {{ strtoupper($vote->choice) }}
                        </span>
                        <div class="small text-muted">{{ $vote->created_at->diffForHumans() }}</div>
                        @if ($vote->comment)
                            <div class="mt-1">{{ $vote->comment }}</div>
                        @endif
                    </div>
                @empty
                    <p class="text-muted">No votes yet.</p>
                @endforelse
            </div>
        </div>

        {{-- Comments thread --}}
        {{-- @dd($voting->comments); --}}
        <div class="card mb-3">
            <div class="card-header">Discussion</div>
            <div class="card-body">
                @if ($voting->comments != [])
                    @forelse($voting->comments->whereNull('parent_id') as $comment)
                        @include('voting.partials.comment', ['comment' => $comment, 'level' => 0])
                    @empty
                        <p class="text-muted">No comments yet.</p>
                    @endforelse
                @endif
            </div>
            {{-- @dd($pool); --}}
            <div class="card-footer">
                <form action="{{ route(''.auth()->user()->custom_role.'.voting.comment.store', $pool->id) }}" method="POST">
                    @csrf
                    <div class="input-group">
                        <input name="message" class="form-control" placeholder="Write a message..." required>
                        <button class="btn btn-primary">Send</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Finalize (only owner or superAdmin) --}}
        @if ((auth()->id() === $voting->owner_id || auth()->user()->role->name === 'familyOwner') &&
                $voting->status !== 'final_decision')
            <div class="card">
                <div class="card-header">Finalize / Mediation Decision</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('familyOwner.voting.finalize', $voting->id) }}">
                        @csrf
                        <div class="mb-2">
                            <label>Notes / Decision</label>
                            <textarea name="final_decision_notes" class="form-control" required></textarea>
                        </div>
                        <button class="btn btn-danger">Make Final Decision (Mediation)</button>
                    </form>
                </div>
            </div>
        @endif
    </div>
@endsection

@push('js')
<script>
function toggleReply(id){
    var el = document.getElementById('reply-form-'+id);
    if(el) el.classList.toggle('d-none');
}
</script>
@endpush