@extends('layouts.app')

@section('content')
    <div class="container">
        <h3>Request Reimbursement</h3>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form method="POST" action="{{ route('' . auth()->user()->role->name . '.reimbursment.store') }}">
            @csrf

            <div class="mb-3">
                <label>Bill (optional)</label>
                <select name="bill_id" class="form-control">
                    <option value="">-- None --</option>
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
                <label>Reason</label>
                <textarea name="reason" class="form-control"></textarea>
            </div>

            <button class="btn btn-primary">Submit</button>
            <a href="{{ route('' . auth()->user()->role->name . '.reimbursment.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
@endsection
