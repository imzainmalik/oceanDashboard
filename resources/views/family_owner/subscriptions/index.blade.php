@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>📊 Subscription Billing</h2>

        <a href="{{ route('payment-methods.index') }}">Payment method</a>
        @if ($target->count())
            <table class="table table-bordered align-middle text-center">
                <thead class="table-light">
                    <tr>
                        <th>Plan Name</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Billing Interval</th>
                        <th>Payment Method</th>
                        <th>Last 4</th>
                        <th>Transaction ID</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($target as $sub)
                        @php
                            // dd($sub);
                            $price = $sub->items->data[0]->price;
                            $product = $price->product;

                            // dd($method);
                            Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

                            $subscription = Stripe\Subscription::retrieve([
                                'id' => $subscriptions_db->stripe_id,
                                'expand' => [
                                    'default_payment_method', // get payment method details
                                    'customer', // include customer info
                                    'latest_invoice.payment_intent', // transaction/payment info
                                    'items.data.price.product', // plan & product info
                                ],
                            ]);

                            $paymentMethodId = $subscription->customer->invoice_settings->default_payment_method;

                            if ($paymentMethodId) {
                                $paymentMethod = Stripe\PaymentMethod::retrieve($paymentMethodId);

                                $last4 = $paymentMethod->card->last4;
                                $brand = $paymentMethod->card->brand;
                            } else {
                                $last4 = null;
                                $brand = null;
                            }

                            // dd($subscription);

                        @endphp

                        <tr>
                            <td>{{ $product->name ?? 'N/A' }}</td>
                            <td>
                                ${{ number_format($price->unit_amount / 100, 2) }}
                            </td>
                            <td>
                                <span
                                    class="badge
                            @if ($sub->status === 'active') bg-success
                            @elseif($sub->status === 'canceled') bg-danger
                            @elseif($sub->status === 'incomplete') bg-warning
                            @else bg-secondary @endif">
                                    {{ ucfirst($sub->status) }}
                                </span>
                            </td>
                            {{-- @dd($sub->items->data[0]->current_period_start); --}}
                            <td>{{ \Carbon\Carbon::createFromTimestamp($sub->items->data[0]->current_period_start)->format('M d, Y') }}
                            </td>
                            <td>{{ \Carbon\Carbon::createFromTimestamp($sub->items->data[0]->current_period_end)->format('M d, Y') }}
                            </td>
                            <td>{{ ucfirst($price->recurring->interval) }}</td>
                            <td>{{ ucfirst($brand ?? 'N/A') }}</td>
                            <td>**** {{ $last4 ?? '----' }}</td>
                            <td>{{ $sub->latest_invoice ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="alert alert-warning text-center mt-3">
                No subscriptions found for this account.
            </div>
        @endif

    </div>
@endsection
