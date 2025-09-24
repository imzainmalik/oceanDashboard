@extends('layouts.app')

@section('content')
    <div class="container">
        <h3>Add Contribution</h3>
        @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        <form method="POST" action="{{ route('familyMember.contribution.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="bill_id">Bill</label>
                <select name="bill_id" class="form-control" required>
                    <option value="">-- Select Bill --</option>
                    @foreach ($bills as $bill)
                        <option value="{{ $bill->id }}">{{ $bill->title }} - ${{ $bill->amount }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label>Amount</label>
                <input type="number" step="0.01" name="amount" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Receipt (Proof)</label>
                <input type="file" name="receipt" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Payment method</label>
                <select name="payment_method" id="payment_method" class="form-control" required>
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
                <input type="text" name="transaction_id" id="transaction_id" class="form-control"
                    placeholder="e.g. Bank Ref #12345">
            </div>

            <div class="mb-3">
                <label>Type</label>
                <select name="type" class="form-control" required>
                    <option value="0">Contribution</option>
                    <option value="1">Shortfall</option>
                </select>
            </div>

            <div class="mb-3">
                <label>Note</label>
                <textarea name="note" class="form-control"></textarea>
            </div>

            <button class="btn btn-success">Save</button>
            <a href="{{ route('familyMember.contribution.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
@endsection
