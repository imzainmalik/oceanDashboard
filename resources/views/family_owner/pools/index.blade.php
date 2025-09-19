@extends('layouts.app')
@section('content')
    <div class="container">
        <a href="{{ route('familyOwner.pools.create') }}" class="btn btn-primary mb-3">+ Create Voting Pool</a>

        <table class="table table-bordered" id="voting-table">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Owner</th>
                    <th>Votes</th>
                    <th>Status</th>
                    <th>Expires</th>
                    <th>Action</th>
                </tr>
            </thead>
        </table>
    </div>
@endsection

@push('js')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <script>
        $(function() {
            $('#voting-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('familyOwner.pools.data') }}',
                columns: [{
                        data: 'title',
                        name: 'title'
                    },
                    {
                        data: 'owner',
                        name: 'owner'
                    },
                    {
                        data: 'votes',
                        name: 'votes',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'voting_expires_at',
                        name: 'voting_expires_at'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });
        });
    </script>
@endpush
