@extends('layouts.app')

@section('content')
    <style>
        .fade:not(.show) {
            opacity: 1;
        }

        /* div#download_monthly {
                                            background-color: #0c0c0c9c;
                                        } */
    </style>
    <div class="container">
        <h5 class="mb-4">All Bill Requests</h5>

        <div class="card shadow">
            <div class="card-body">
                <table class="table table-striped table-hover align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Bill Title</th>
                            <th>Amount</th>
                            <th>Payer</th>
                            <th>Payment Method</th>
                            <th>Status</th>
                            <th>Receipt</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bills as $bill)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $bill->title }}</td>
                                <td>${{ number_format($bill->amount, 2) }}</td>
                                <td>{{ $bill->assignee->name ?? 'N/A' }}</td>
                                <td>{{ ucfirst($bill->payment_method) }}</td>
                                <td>
                                    <span
                                        class="badge 
                                    @if ($bill->status === 'pending') bg-warning
                                    @elseif($bill->status === 'approved') bg-success
                                    @elseif($bill->status === 'declined') bg-danger
                                    @else bg-secondary @endif">
                                        {{ ucfirst($bill->status) }}
                                    </span>
                                </td>
                                {{-- @dd(auth()->user()->custom_role); --}}
                                <td>
                                    @if ($bill->payments->count() > 0)
                                        <a href="{{ route('' . auth()->user()->custom_role . '.bills.show', $bill->id) }}"
                                            class="btn btn-sm btn-info">
                                            View Receipt
                                        </a>
                                    @else
                                        <span class="text-muted">Not Uploaded</span>
                                    @endif
                                </td>
                                <td>
                                    @if (auth()->user()->id === $bill->owner_id && $bill->status === 'pending')
                                        <form action="{{ route('familyOwner.bills.approve', $bill->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <button class="btn btn-sm btn-success">Approve</button>
                                        </form>

                                        <form action="{{ route('familyOwner.bills.decline', $bill->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <button class="btn btn-sm btn-danger">Decline</button>
                                        </form>
                                    @else
                                        <em class="text-muted">No Action</em>
                                    @endif

                                    @if (auth()->user()->id == $bill->assigned_to)
                                        <button class="btn btn-primary" data-toggle="modal"
                                            data-target="#exampleModal_{{ $bill->id }}">Submit Payment</button>
                                        <div class="modal fade" id="exampleModal_{{ $bill->id }}" tabindex="-1"
                                            role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form method="POST"
                                                            action="{{ route('senior.bills.submitPayment', $bill->id) }}"
                                                            enctype="multipart/form-data">
                                                            @csrf

                                                            <div class="mb-3">
                                                                <label for="amount" class="form-label">Payment
                                                                    Amount</label>
                                                                <input type="number" step="0.01" name="amount"
                                                                    id="amount" class="form-control"
                                                                    value="{{ $bill->amount }}" required>
                                                            </div>

                                                            <div class="mb-3">
                                                                <label for="payment_method" class="form-label">Payment
                                                                    Method</label>
                                                                <select name="payment_method" id="payment_method"
                                                                    class="form-select" required>
                                                                    <option value="">-- Select Payment Method --
                                                                    </option>
                                                                    <option value="cashapp">Cash App</option>
                                                                    <option value="zelle">Zelle</option>
                                                                    <option value="paypal">PayPal</option>
                                                                    <option value="bank_transfer">Bank Transfer</option>
                                                                    <option value="other">Other</option>
                                                                </select>
                                                            </div>

                                                            <div class="mb-3">
                                                                <label for="transaction_id" class="form-label">Transaction
                                                                    ID (if available)</label>
                                                                <input type="text" name="transaction_id"
                                                                    id="transaction_id" class="form-control"
                                                                    placeholder="e.g. Bank Ref #12345">
                                                            </div>

                                                            <div class="mb-3">
                                                                <label for="receipt" class="form-label">Upload Receipt
                                                                    (Proof)
                                                                </label>
                                                                <input type="file" name="receipt" id="receipt"
                                                                    class="form-control" accept="image/*,.pdf">
                                                                <small class="text-muted">Upload a receipt or screenshot as
                                                                    proof of payment.</small>
                                                            </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary">
                                                            Submit Payment
                                                        </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted">No bills found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
@endpush
