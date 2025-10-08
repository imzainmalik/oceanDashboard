@extends('layouts.app')
@section('content')


    <div class="container">

        <div class="card">
            <div class="card-header">
                <h3>Edit Reimbursement</h3>
            </div>
            <div class="card-body"> 
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form method="POST" action="{{ route('' . auth()->user()->role->name . '.reimbursment.update', $reimbursement->id) }}">
                    @csrf @method('PUT')

                    <div class="mb-3">
                        <label>Bill (optional)</label>
                        <select name="bill_id" class="form-control">
                            <option value="">-- None --</option>
                            @foreach ($bills as $bill)
                                <option value="{{ $bill->id }}" @selected($reimbursement->bill_id == $bill->id)>
                                    {{ $bill->title }} - ${{ $bill->amount }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label>Amount</label>
                        <input type="number" step="0.01" name="amount" value="{{ $reimbursement->amount }}"
                            class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Reason</label>
                        <textarea name="reason" class="form-control">{{ $reimbursement->reason }}</textarea>
                    </div>

                    <button class="btn btn-success">Update</button>
                    <a href="{{ route('' . auth()->user()->role->name . '.reimbursment.index') }}" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>

@endsection
