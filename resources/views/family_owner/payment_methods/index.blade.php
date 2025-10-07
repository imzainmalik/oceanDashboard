@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h3 class="mb-4">💳 My Saved Cards</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row">
        @forelse ($paymentMethods as $method)
            @php
                $card = $method->card;
                $isPrimary = $method->id === $defaultPaymentMethod;
            @endphp

            <div class="col-md-4">
                <div class="card shadow-sm mb-4 {{ $isPrimary ? 'border-primary' : '' }}">
                    <div class="card-body text-center">
                        <img src="{{ asset('images/cards/' . strtolower($card->brand) . '.png') }}"  alt="{{ ucfirst($card->brand) }}" width="50" class="mb-3">

                        <h5 class="mb-2">{{ ucfirst($card->brand) }} •••• {{ $card->last4 }}</h5>
                        <p class="text-muted mb-2">Exp: {{ $card->exp_month }}/{{ $card->exp_year }}</p>

                        @if ($isPrimary)
                            <span class="badge bg-primary">Primary</span>
                        @else
                            <form action="{{ route('payment-methods.setPrimary', $method->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="payment_method_id" value="{{ $method->id }}">
                                <button type="submit" class="btn btn-outline-primary btn-sm">
                                    Set as Primary
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <p class="text-muted">No saved cards found.</p>
        @endforelse
    </div>
</div>
@endsection
