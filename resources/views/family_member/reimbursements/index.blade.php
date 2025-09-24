@extends('layouts.app')

@section('content')
<div class="container">
    <h3>My Reimbursements</h3>

    <a href="{{ route('familyMember.reimbursment.create') }}" class="btn btn-primary mb-3">Request Reimbursement</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Bill</th>
                <th>Amount</th>
                <th>Reason</th>
                <th>Status</th>
                <th>Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        @forelse($reimbursements as $r)
            <tr>
                <td>{{ $r->bill?->title ?? 'N/A' }}</td>
                <td>${{ number_format($r->amount, 2) }}</td>
                <td>{{ $r->reason ?? '-' }}</td>
                <td>
                    <span class="badge 
                        @if($r->status == 'pending') bg-warning
                        @elseif($r->status == 'approved') bg-success
                        @else bg-danger @endif">
                        {{ ucfirst($r->status) }}
                    </span>
                </td>
                <td>{{ $r->created_at->format('M d, Y') }}</td>
                <td>
                    <a href="{{ route('familyMember.reimbursment.edit',$r->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form method="POST" action="{{ route('familyMember.reimbursment.destroy',$r->id) }}" style="display:inline">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this reimbursement?')">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="6" class="text-center">No reimbursements found.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
@endsection
