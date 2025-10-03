@extends('layouts.app')

@section('content')
    <div class="container">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="home-tab" data-toggle="tab" data-target="#home" type="button"
                    role="tab" aria-controls="home" aria-selected="true">Regular Document Vault</button>
            </li>
             {{-- @if (auth()->user()->hasPermission('medical_docs_insert') || auth()->user()->check_if_owner == 4 != null) --}}
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="profile-tab" data-toggle="tab" data-target="#profile" type="button"
                    role="tab" aria-controls="profile" aria-selected="false">Medical Document Vault</button>
            </li>
            {{-- @endif --}}
            {{-- @if (auth()->user()->hasPermission('insurance_docs_insert') || auth()->user()->check_if_owner == 4 != null) --}}
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="insurance-doc-tab" data-toggle="tab" data-target="#insurance-doc-body" type="button"
                    role="tab" aria-controls="profile" aria-selected="false">Insurance Document Vault</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="emegency-doc-tab" data-toggle="tab" data-target="#emegency-doc-body" type="button"
                    role="tab" aria-controls="profile" aria-selected="false">Emergency Document Vault</button>
            </li>
            {{-- @endif --}}
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                <div class="container mt-4">
                    <div class="card shadow-sm">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-3">
                                    <h5>Regular Document Requests</h5>
                                </div>
                                <div class="col-9 d-flex justify-content-end">
                                    <a href="{{ route('document.requests.create') }}" class="btn btn-sm btn-primary">Request
                                        for
                                        File</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Title</th>
                                        <th>Requester</th>
                                        <th>Target User</th>
                                        <th>Status</th>
                                        <th>Deadline</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($requests as $req)
                                     @if ($req->type == 0)
                                        <tr>
                                            <td>{{ $req->id }}</td>
                                            <td>{{ $req->title }}</td>
                                            <td>{{ $req->requester->name }}</td>
                                            <td>{{ $req->target->name }}</td>
                                            <td>
                                                @if ($req->status === 'pending')
                                                    <span class="badge bg-warning text-dark">Pending</span>
                                                @elseif($req->status === 'submitted')
                                                    <span class="badge bg-success">Submitted</span>
                                                @elseif($req->status === 'expired')
                                                    <span class="badge bg-secondary">Expired</span>
                                                @else
                                                    <span class="badge bg-danger">Cancelled</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($req->status === 'pending')
                                                    <span class="countdown"
                                                        data-deadline="{{ $req->expires_at->toIsoString() }}"></span>
                                                @else
                                                    {{ $req->expires_at->format('d M Y H:i') }}
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('document.requests.show', $req->id) }}"
                                                    class="btn btn-sm btn-primary">View</a>
                                                @if ($req->status === 'submitted' && $req->document)
                                                    <a href="{{ route('document.requests.download', $req->id) }}"
                                                        class="btn btn-sm btn-success">Download</a>
                                                @endif
                                                @if (auth()->id() === $req->requester_id && $req->status === 'pending')
                                                    <form action="{{ route('document.requests.cancel', $req->id) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        <button class="btn btn-sm btn-danger"
                                                            onclick="return confirm('Cancel this request?')">Cancel</button>
                                                    </form>
                                                @endif
                                            </td>
                                        </tr> 
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                <div class="container mt-4">
                    <div class="card shadow-sm">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-3">
                                    <h5>Medical Document Requests</h5>
                                </div>
                                <div class="col-9 d-flex justify-content-end">
                                    <a href="{{ route('document.requests.create') }}"
                                        class="btn btn-sm btn-primary">Request for
                                        File</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Title</th>
                                        <th>Requester</th>
                                        <th>Target User</th>
                                        <th>Status</th>
                                        <th>Deadline</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($requests as $req)
                                        @if ($req->type == 1)
                                            <tr>
                                                <td>{{ $req->id }}</td>
                                                <td>{{ $req->title }}</td>
                                                <td>{{ $req->requester->name }}</td>
                                                <td>{{ $req->target->name }}</td>
                                                <td>
                                                    @if ($req->status === 'pending')
                                                        <span class="badge bg-warning text-dark">Pending</span>
                                                    @elseif($req->status === 'submitted')
                                                        <span class="badge bg-success">Submitted</span>
                                                    @elseif($req->status === 'expired')
                                                        <span class="badge bg-secondary">Expired</span>
                                                    @else
                                                        <span class="badge bg-danger">Cancelled</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($req->status === 'pending')
                                                        <span class="countdown"
                                                            data-deadline="{{ $req->expires_at->toIsoString() }}"></span>
                                                    @else
                                                        {{ $req->expires_at->format('d M Y H:i') }}
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ route('document.requests.show', $req->id) }}"
                                                        class="btn btn-sm btn-primary">View</a>
                                                    @if ($req->status === 'submitted' && $req->document)
                                                        <a href="{{ route('document.requests.download', $req->id) }}"
                                                            class="btn btn-sm btn-success">Download</a>
                                                    @endif
                                                    @if (auth()->id() === $req->requester_id && $req->status === 'pending')
                                                        <form action="{{ route('document.requests.cancel', $req->id) }}"
                                                            method="POST" class="d-inline">
                                                            @csrf
                                                            <button class="btn btn-sm btn-danger"
                                                                onclick="return confirm('Cancel this request?')">Cancel</button>
                                                        </form>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endif
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center text-muted">No document requests found.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="insurance-doc-body" role="tabpanel" aria-labelledby="profile-tab">
                <div class="container mt-4">
                    <div class="card shadow-sm">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-3">
                                    <h5>Insurance Document Requests</h5>
                                </div>
                                <div class="col-9 d-flex justify-content-end">
                                    <a href="{{ route('document.requests.create') }}"
                                        class="btn btn-sm btn-primary">Request for
                                        File</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Title</th>
                                        <th>Requester</th>
                                        <th>Target User</th>
                                        <th>Status</th>
                                        <th>Deadline</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($requests as $req)
                                        @if ($req->type == 2)
                                            <tr>
                                                <td>{{ $req->id }}</td>
                                                <td>{{ $req->title }}</td>
                                                <td>{{ $req->requester->name }}</td>
                                                <td>{{ $req->target->name }}</td>
                                                <td>
                                                    @if ($req->status === 'pending')
                                                        <span class="badge bg-warning text-dark">Pending</span>
                                                    @elseif($req->status === 'submitted')
                                                        <span class="badge bg-success">Submitted</span>
                                                    @elseif($req->status === 'expired')
                                                        <span class="badge bg-secondary">Expired</span>
                                                    @else
                                                        <span class="badge bg-danger">Cancelled</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($req->status === 'pending')
                                                        <span class="countdown"
                                                            data-deadline="{{ $req->expires_at->toIsoString() }}"></span>
                                                    @else
                                                        {{ $req->expires_at->format('d M Y H:i') }}
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ route('document.requests.show', $req->id) }}"
                                                        class="btn btn-sm btn-primary">View</a>
                                                    @if ($req->status === 'submitted' && $req->document)
                                                        <a href="{{ route('document.requests.download', $req->id) }}"
                                                            class="btn btn-sm btn-success">Download</a>
                                                    @endif
                                                    @if (auth()->id() === $req->requester_id && $req->status === 'pending')
                                                        <form action="{{ route('document.requests.cancel', $req->id) }}"
                                                            method="POST" class="d-inline">
                                                            @csrf
                                                            <button class="btn btn-sm btn-danger"
                                                                onclick="return confirm('Cancel this request?')">Cancel</button>
                                                        </form>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endif
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center text-muted">No document requests found.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="emegency-doc-body" role="tabpanel" aria-labelledby="profile-tab">
                <div class="container mt-4">
                    <div class="card shadow-sm">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-3">
                                    <h5>Insurance Document Requests</h5>
                                </div>
                                <div class="col-9 d-flex justify-content-end">
                                    <a href="{{ route('document.requests.create') }}"
                                        class="btn btn-sm btn-primary">Request for
                                        File</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Title</th>
                                        <th>Requester</th>
                                        <th>Target User</th>
                                        <th>Status</th>
                                        <th>Deadline</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($requests as $req)
                                        @if ($req->type == 3)
                                            <tr>
                                                <td>{{ $req->id }}</td>
                                                <td>{{ $req->title }}</td>
                                                <td>{{ $req->requester->name }}</td>
                                                <td>{{ $req->target->name }}</td>
                                                <td>
                                                    @if ($req->status === 'pending')
                                                        <span class="badge bg-warning text-dark">Pending</span>
                                                    @elseif($req->status === 'submitted')
                                                        <span class="badge bg-success">Submitted</span>
                                                    @elseif($req->status === 'expired')
                                                        <span class="badge bg-secondary">Expired</span>
                                                    @else
                                                        <span class="badge bg-danger">Cancelled</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($req->status === 'pending')
                                                        <span class="countdown"
                                                            data-deadline="{{ $req->expires_at->toIsoString() }}"></span>
                                                    @else
                                                        {{ $req->expires_at->format('d M Y H:i') }}
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ route('document.requests.show', $req->id) }}"
                                                        class="btn btn-sm btn-primary">View</a>
                                                    @if ($req->status === 'submitted' && $req->document)
                                                        <a href="{{ route('document.requests.download', $req->id) }}"
                                                            class="btn btn-sm btn-success">Download</a>
                                                    @endif
                                                    @if (auth()->id() === $req->requester_id && $req->status === 'pending')
                                                        <form action="{{ route('document.requests.cancel', $req->id) }}"
                                                            method="POST" class="d-inline">
                                                            @csrf
                                                            <button class="btn btn-sm btn-danger"
                                                                onclick="return confirm('Cancel this request?')">Cancel</button>
                                                        </form>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endif
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center text-muted">No document requests found.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"
        integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+" crossorigin="anonymous">
    </script>

    <script>
        function updateCountdowns() {
            document.querySelectorAll('.countdown').forEach(function(el) {
                const deadline = new Date(el.dataset.deadline);
                const now = new Date();
                const diff = deadline - now;

                if (diff <= 0) {
                    el.textContent = 'Expired';
                    return;
                }

                const secs = Math.floor(diff / 1000) % 60;
                const mins = Math.floor(diff / 60000) % 60;
                const hours = Math.floor(diff / 3600000) % 24;
                const days = Math.floor(diff / 86400000);

                el.textContent = (days ? days + 'd ' : '') + String(hours).padStart(2, '0') + ':' + String(mins)
                    .padStart(2, '0') + ':' + String(secs).padStart(2, '0');
            });
        }
        updateCountdowns();
        setInterval(updateCountdowns, 1000);
    </script>
@endpush
