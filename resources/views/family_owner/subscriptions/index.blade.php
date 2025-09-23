@extends('layouts.app')

@section('content')
<div class="container">
    <h2>📊 Subscription Billing</h2>

    <a href="{{ route('payment-methods.index') }}">Payment method</a>
    @if($subscriptions->count())
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Plan</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Payment Gateway</th>
                    <th>Transaction</th>
                </tr>
            </thead>
            <tbody>
                @foreach($subscriptions as $sub)
                <tr>
                    <td>{{ ucfirst($sub->plan) }}</td>
                    <td>${{ number_format($sub->amount, 2) }}</td>
                    <td>
                        <span class="badge bg-{{ $sub->status == 'active' ? 'success' : ($sub->status == 'expired' ? 'secondary' : 'danger') }}">
                            {{ ucfirst($sub->status) }}
                        </span>
                    </td>
                    <td>{{ $sub->start_date }}</td>
                    <td>{{ $sub->end_date ?? '-' }}</td>
                    <td>{{ ucfirst($sub->payment_gateway) }}</td>
                    <td>{{ $sub->transaction_id ?? '-' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p class="text-muted">No subscription records found.</p>
    @endif
</div>
@endsection
