@extends('layouts.app')

@section('content')
    <div class="container my-5">
        <div class="row justify-content-center">
            <!-- Standard -->
            <div class="col-md-4">
                <div class="card shadow-lg border-0 rounded-3 text-center h-100">
                    <div class="card-header bg-primary text-white">
                        <h4 class="my-0">Standard</h4>
                    </div>
                    <div class="card-body">
                        <h1 class="card-title pricing-card-title">$19 <small class="text-muted">/ mo</small></h1>
                        <ul class="list-unstyled mt-3 mb-4">
                            <li>✔ 5 Projects</li>
                            <li>✔ Basic Support</li>
                            <li>✔ 10 GB Storage</li>
                            <li>✖ No Team Access</li>
                        </ul>
                        <a href="{{ route('subscription.payment', ['price_id'=> 'price_1SED8FIqrFLrMDhXghvgZzo7','type' => 'standard','price' => '99']) }}" class="btn btn-outline-primary">Choose Standard</a>
                    </div>
                </div>
            </div>

            <!-- Premium -->
            <div class="col-md-4">
                <div class="card shadow-lg border-0 rounded-3 text-center h-100">
                    <div class="card-header bg-success text-white">
                        <h4 class="my-0">Premium</h4>
                    </div>
                    <div class="card-body">
                        <h1 class="card-title pricing-card-title">$49 <small class="text-muted">/ mo</small></h1>
                        <ul class="list-unstyled mt-3 mb-4">
                            <li>✔ 20 Projects</li>
                            <li>✔ Priority Support</li>
                            <li>✔ 100 GB Storage</li>
                            <li>✔ Team Access</li>
                        </ul>
                        <a href="#" class="btn btn-success">Choose Premium</a>
                    </div>
                </div>
            </div>

            <!-- Professional -->
            <div class="col-md-4">
                <div class="card shadow-lg border-0 rounded-3 text-center h-100">
                    <div class="card-header bg-dark text-white">
                        <h4 class="my-0">Professional</h4>
                    </div>
                    <div class="card-body">
                        <h1 class="card-title pricing-card-title">$99 <small class="text-muted">/ mo</small></h1>
                        <ul class="list-unstyled mt-3 mb-4">
                            <li>✔ Unlimited Projects</li>
                            <li>✔ 24/7 Premium Support</li>
                            <li>✔ 1 TB Storage</li>
                            <li>✔ Advanced Team Tools</li>
                        </ul>
                        <a href="#" class="btn btn-dark">Choose Professional</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        const stripe = Stripe("{{ config('cashier.key') }}");
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
                alert(error.message);
            } else {
                let hidden = document.createElement('input');
                hidden.type = 'hidden';
                hidden.name = 'payment_method';
                hidden.value = paymentMethod.id;
                form.appendChild(hidden);
                form.submit();
            }
        });
    </script>
@endpush
