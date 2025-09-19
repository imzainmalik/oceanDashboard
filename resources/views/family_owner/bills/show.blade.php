@extends('layouts.app')

@section('content')
    <div class="container">
        <form action="{{ route('bills.submitPayment', $bill->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label>Amount Paid</label>
                <input type="number" name="amount_paid" step="0.01" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Payment Method</label>
                <select name="payment_method" class="form-select">
                    <option value="zelle">Zelle</option>
                    <option value="cash_app">Cash App</option>
                    <option value="other">Other</option>
                </select>
            </div>
            <div class="mb-3">
                <label>Confirmation Number</label>
                <input type="text" name="confirmation_number" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Upload Receipt</label>
                <input type="file" name="receipt" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Submit Payment</button>
        </form>


    </div>
@endsection
