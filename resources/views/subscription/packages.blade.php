@extends('layouts.app')

@section('content')
    <div class="container my-5">
        <div class="row justify-content-center">
            <!-- Standard -->
            <div class="col-md-4">
                <div class="card shadow-lg border-0 rounded-3 text-center h-100">
                    <div class="card-header bg-primary text-white">
                        <h4 class="my-0 text-white">Standard</h4>
                    </div>
                    <div class="card-body">
                        <h1 class="card-title pricing-card-title">$99 <small class="text-muted">/ mo</small></h1>
                        {{-- <ul class="list-unstyled mt-3 mb-4">
                            <li>✔ 5 Projects</li>
                            <li>✔ Basic Support</li>
                            <li>✔ 10 GB Storage</li>
                            <li>✖ No Team Access</li>
                        </ul> --}}
                        <a href="{{ route('subscription.payment', ['price_id'=> 'price_1SFIDgIqrFLrMDhXGayZqWR8','type' => 'standard','price' => '99']) }}" class="btn btn-outline-primary">Choose Standard</a>
                    </div>
                </div>
            </div>

            <!-- Premium -->
            <div class="col-md-4">
                <div class="card shadow-lg border-0 rounded-3 text-center h-100">
                    <div class="card-header bg-success text-white">
                        <h4 class="my-0 text-white" >Premium</h4>
                    </div>
                    <div class="card-body">
                        <h1 class="card-title pricing-card-title">$150 <small class="text-muted">/ Qu</small></h1>
                        {{-- <ul class="list-unstyled mt-3 mb-4">
                            <li>✔ 20 Projects</li>
                            <li>✔ Priority Support</li>
                            <li>✔ 100 GB Storage</li>
                            <li>✔ Team Access</li>
                        </ul> --}}
                        <a href="{{ route('subscription.payment', ['price_id'=> 'price_1SFIDgIqrFLrMDhXGayZqWR8','type' => 'premium','price' => '150']) }}" class="btn btn-success">Choose Premium</a>
                    </div>
                </div>
            </div>

            <!-- Professional -->
            <div class="col-md-4">
                <div class="card shadow-lg border-0 rounded-3 text-center h-100">
                    <div class="card-header bg-dark text-white">
                        <h4 class="my-0 text-white">Professional</h4>
                    </div>
                    <div class="card-body">
                        <h1 class="card-title pricing-card-title">$399 <small class="text-muted">/ Yr</small></h1>
                        {{-- <ul class="list-unstyled mt-3 mb-4">
                            <li>✔ Unlimited Projects</li>
                            <li>✔ 24/7 Premium Support</li>
                            <li>✔ 1 TB Storage</li>
                            <li>✔ Advanced Team Tools</li>
                        </ul> --}}
                        <a href="{{ route('subscription.payment', ['price_id'=> 'price_1SFIEeIqrFLrMDhXF6KkewxX','type' => 'professional','price' => '399']) }}" class="btn btn-dark">Choose Professional</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
 