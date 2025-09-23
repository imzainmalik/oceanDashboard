@extends('layouts.app')

@section('content')
<div class="container">
    <h2>💳 Payment Methods</h2>

    {{-- <form method="POST" action="{{ route('payment-methods.store') }}" class="mb-4">
        @csrf
        <div class="row g-2">
            <div class="col-md-3"><input type="text" name="card_brand" placeholder="Brand (Visa)" class="form-control" required></div>
            <div class="col-md-2"><input type="text" name="card_last_four" placeholder="Last 4" class="form-control" required></div>
            <div class="col-md-2"><input type="text" name="expiry_month" placeholder="MM" class="form-control" required></div>
            <div class="col-md-2"><input type="text" name="expiry_year" placeholder="YYYY" class="form-control" required></div>
            <div class="col-md-2"><button class="btn btn-primary w-100">Add Card</button></div>
        </div>
    </form> --}}

    @if($methods->count())
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Brand</th>
                    <th>Last 4</th>
                    <th>Expiry</th>
                    <th>Primary</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($methods as $method)
                <tr>
                    <td>{{ $method->card_brand }}</td>
                    <td>**** {{ $method->card_last_four }}</td>
                    <td>{{ $method->expiry_month }}/{{ $method->expiry_year }}</td>
                    <td>
                        @if($method->is_primary)
                            <span class="badge bg-success">Primary</span>
                        @else
                            <form method="POST" action="{{ route('payment-methods.setPrimary', $method->id) }}">
                                @csrf
                                <button class="btn btn-sm btn-outline-info">Set Primary</button>
                            </form>
                        @endif
                    </td>
                    <td>
                        <form method="POST" action="{{ route('payment-methods.destroy', $method->id) }}">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Remove this card?')">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p class="text-muted">No cards added yet.</p>
    @endif
</div>
@endsection
