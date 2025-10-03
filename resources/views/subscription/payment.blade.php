@extends('layouts.app')

@section('content')
    <form id="payment-form" action="{{ route('subscription.payment.store', ['price_id' => $request->price_id]) }}"
        method="POST">
        @csrf
        <div id="card-element"><!-- Stripe Card Element --></div>
        <button id="submit-btn">Subscribe</button>
        {{-- <input type="hidden" value="{{ $request->price_id }}"/> --}}
        <div class="alert alert-danger" id="error-alert" style="display:none;"></div>

        <input type="hidden" name="type" value="{{ $request->type }}"/>
        <input type="hidden" name="packge_price" value="{{ $request->price_id }}"/>
    </form>
@endsection
@push('js')
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        const stripe = Stripe("{{ env('STRIPE_KEY') }}");
        const elements = stripe.elements();
        const cardElement = elements.create('card');
        cardElement.mount('#card-element');

        const form = document.getElementById('payment-form');
        form.addEventListener('submit', async (e) => {
            e.preventDefault();

            const {
                paymentMethod,
                error
            } = await stripe.createPaymentMethod({
                type: 'card',
                card: cardElement,
            });

            if (error) {
                const alert = document.getElementById('error-alert');
                alert.innerHTML = error.message;
                alert.style.display = "block";
            } else {
                // Debug: see what ID we got
                console.log("PaymentMethod ID:", paymentMethod.id);

                let hidden = document.createElement('input');
                hidden.type = 'hidden';
                hidden.name = 'payment_method';
                hidden.value = paymentMethod.id; // should look like pm_123456789
                form.appendChild(hidden);

                form.submit();
            }
        });
    </script>
@endpush
