@extends('layouts.app')

@section('content')
    <div class="container">
        <h3>💳 Payment History for Bill: {{ $bill->title }}</h3>

        <a href="{{ route('' . auth()->user()->custom_role . '.bills.index') }}" class="btn btn-secondary mb-3">⬅ Back to
            Bills</a>

        @if ($payments->count() > 0)
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Amount</th>
                        <th>Method</th>
                        <th>Transaction ID</th>
                        <th>Submit Proof</th>
                        <th>Payment type</th>

                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($payments as $payment)
                        <tr>
                            <td>${{ number_format($payment->amount_paid, 2) }}</td>
                            <td>{{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }}</td>
                            <td>{{ $payment->confirmation_number ?? '-' }}</td>
                            <td><img src="{{ asset('payment_proof/' . $payment->receipt_path) }}" style="width:100px;" /></td>
                            <td>
                                @if ($payment->type == 0)
                                    Contributed
                                @else
                                    Shortfall
                                @endif
                            </td>
                            <td>
                                @if ($bill->status === 'approved')
                                    <span class="badge bg-success">Approved</span>
                                @elseif($bill->status === 'rejected')
                                    <span class="badge bg-danger">Rejected</span>
                                @else
                                    <span class="badge bg-warning text-dark">Pending Review</span>
                                @endif
                            </td>
                            <td>{{ $payment->created_at->format('d M, Y h:i A') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="alert alert-info">
                No payments submitted yet for this bill.
            </div>
        @endif
    </div>
@endsection
