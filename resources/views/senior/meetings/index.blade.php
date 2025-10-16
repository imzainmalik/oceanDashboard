@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

    <div class="card">
        <div class="secondary-card-header">
            <h3>📅 My Meetings</h3>

        </div>
        <div class="card-body">
            <a href="{{ route('' . auth()->user()->custom_role . '.meetings.create') }}" class="btn btn-primary mb-3">Schedule
                Meeting</a>
            <div class="col-lg-12" bis_skin_checked="1">
                <div class="orderTable" bis_skin_checked="1">
                    <table class="table" id="meetings-table">
                        <thead>
                            <tr>
                                <th>Topic</th>
                                <th>Agenda</th>
                                <th>Start Time</th>
                                <th>Status</th>
                                <th>Links</th>
                                <th>IsActive</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <script>
$(function () {
    $('#meetings-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route(auth()->user()->custom_role.'.meetings.index') }}",
        columns: [
            { data: 'topic', name: 'topic' },
            { data: 'agenda', name: 'agenda' },
            { data: 'start_time', name: 'start_time' },
            { data: 'status', name: 'status', orderable: false, searchable: false },
            { data: 'links', name: 'links', orderable: false, searchable: false },
            { data: 'is_active', name: 'is_active', orderable: false, searchable: false },
            { data: 'actions', name: 'actions', orderable: false, searchable: false }
        ],
        order: [[1, 'desc']]
    });
});
    </script>
@endpush
