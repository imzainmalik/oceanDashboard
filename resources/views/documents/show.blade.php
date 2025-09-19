@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <h4>{{ $documentRequest->title }}</h4>
                <p class="text-muted">Requested by: {{ $documentRequest->requester->name }}</p>
                <p>{{ $documentRequest->message }}</p>

                <p><strong>Deadline:</strong> <span id="deadline">{{ $documentRequest->expires_at->toIsoString() }}</span>
                </p>

                @if ($documentRequest->status === 'pending' && auth()->id() === $documentRequest->target_user_id)
                    <div class="mb-3">
                        <div id="countdown" class="h5 text-danger"></div>
                    </div>

                    <form action="{{ route('document.requests.submit', $documentRequest->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="mb-2">
                            <input type="file" name="file" class="form-control" accept=".pdf,.jpg,.png,.doc,.docx"
                                required>
                        </div>
                        <button class="btn btn-success">Submit Document</button>
                    </form>
                @endif

                @if ($documentRequest->status === 'submitted')
                    <div class="alert alert-success">Document submitted by {{ $documentRequest->document->uploader->name }}.
                        <a href="{{ route('document.requests.download', $documentRequest->id) }}"
                            class="btn btn-sm btn-primary ms-2">Download</a>
                    </div>
                @endif

                @if ($documentRequest->status === 'pending' && auth()->id() === $documentRequest->requester_id)
                    <div class="alert alert-info">You will be notified when the document is submitted.</div>
                @endif

                @if ($documentRequest->status === 'expired')
                    <div class="alert alert-warning">This request expired at
                        {{ $documentRequest->expires_at->toDayDateTimeString() }}</div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        // Countdown: reads ISO time from #deadline and updates #countdown
        (function() {
            const deadlineIso = document.getElementById('deadline').textContent.trim();
            const deadline = new Date(deadlineIso);
            const cdEl = document.getElementById('countdown');

            if (!deadline || !cdEl) return;

            function update() {
                const now = new Date();
                const diff = deadline - now;
                if (diff <= 0) {
                    cdEl.textContent = 'Deadline passed';
                    // optionally force a reload to update status
                    // location.reload();
                    return;
                }
                const secs = Math.floor(diff / 1000) % 60;
                const mins = Math.floor(diff / 60000) % 60;
                const hours = Math.floor(diff / 3600000) % 24;
                const days = Math.floor(diff / 86400000);
                cdEl.textContent = (days ? days + 'd ' : '') + String(hours).padStart(2, '0') + ':' + String(mins)
                    .padStart(2, '0') + ':' + String(secs).padStart(2, '0');
            }

            update();
            setInterval(update, 1000);
        })();
    </script>
@endpush
