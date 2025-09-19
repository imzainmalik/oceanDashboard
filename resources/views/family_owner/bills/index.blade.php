@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">All Bill Requests</h2>

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
                                <span class="badge 
                                    @if($bill->status === 'pending') bg-warning
                                    @elseif($bill->status === 'approved') bg-success
                                    @elseif($bill->status === 'declined') bg-danger
                                    @else bg-secondary @endif">
                                    {{ ucfirst($bill->status) }}
                                </span>
                            </td>
                            <td>
                                @if($bill->receipt_path)
                                    <a href="{{ asset('storage/'.$bill->receipt_path) }}" target="_blank" class="btn btn-sm btn-info">
                                        View Receipt
                                    </a>
                                @else
                                    <span class="text-muted">Not Uploaded</span>
                                @endif
                            </td>
                            <td>
                                @if(auth()->user()->id === $bill->owner_id && $bill->status === 'pending')
                                    <form action="{{ route('familyOwner.bills.approve', $bill->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PUT')
                                        <button class="btn btn-sm btn-success">Approve</button>
                                    </form>

                                    <form action="{{ route('familyOwner.bills.decline', $bill->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PUT')
                                        <button class="btn btn-sm btn-danger">Decline</button>
                                    </form>
                                @else
                                    <em class="text-muted">No Action</em>
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
