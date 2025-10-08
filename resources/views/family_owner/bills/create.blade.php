@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="mb-4">Create Bill Request</h2>

        <div class="card shadow">
            <div class="card-body">
                <form action="{{ route(''.auth()->user()->role->name.'.bills.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label for="type" class="form-label">Bill type</label>
                        <select name="type" id="type" class="form-control" required>
                            <option value="" selected disabled>-- Select Bill type --</option>
                            <option value="0">Regular Bill</option>
                            <option value="1">Medical bill</option> 
                        </select>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="title" class="form-label">Bill Title</label>
                            <input type="text" name="title" id="title" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label for="amount" class="form-label">Amount</label>
                            <input type="number" step="0.01" name="amount" id="amount" class="form-control" required>
                        </div>
                        <div class="col-md-12">
                            <label for="assigned_to" class="form-label">Select Payer</label>
                            <select name="assigned_to" id="assigned_to" class="form-control" required>
                                <option value="" selected disabled>-- Select Payer --</option>
                                @foreach($members as $member)
                                     <option value="{{ $member->users->id }}">{{ $member->users->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="payment_method" class="form-label">Payment Method</label>
                        <select name="payment_method" id="payment_method" class="form-control" required>
                            <option value="">-- Select Payment Method --</option>
                            <option value="cashapp">Cash App</option>
                            <option value="zelle">Zelle</option>
                            <option value="paypal">PayPal</option>
                            <option value="bank_transfer">Bank Transfer</option>
                            <option value="other">Other</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="receipt" class="form-label">Upload Receipt (Proof)</label>
                        <input type="file" name="receipt" id="receipt" class="form-control" accept="image/*,.pdf">
                        <small class="text-muted">Upload a receipt or screenshot as proof of payment.</small>
                    </div>

                    <div class="mb-3">
                        <label for="details" class="form-label">Additional Details</label>
                        <textarea name="details" id="details" rows="3" class="form-control"></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">Submit Bill Request</button>
                    <a href="{{ route(''.auth()->user()->role->name.'.bills.index') }}" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
@endsection
