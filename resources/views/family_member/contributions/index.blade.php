@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

    <div class="container py-4">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-2">
                        <h3>My Contributions</h3>
                    </div>
                    <div class="col-10 d-flex justify-content-end">
                        <a href="{{ route('familyMember.contribution.create') }}" class="btn btn-primary">Create
                            contribution</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-bordered" id="contributions-table">
                    <thead>
                        <tr>
                            <th>Bill</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Payment Type</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <script>
        $(function() {
            $('#contributions-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('familyMember.contribution.index') }}",
                columns: [{
                        data: 'bill',
                        name: 'bill.title'
                    },
                    {
                        data: 'amount',
                        name: 'amount_paid'
                    },
                    {
                        data: 'status',
                        name: 'bill.status',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'date',
                        name: 'date'
                    },
                    {
                        data: 'payment_type',
                        name: 'type'
                    }
                ]
            });
        });
    </script>
@endpush
