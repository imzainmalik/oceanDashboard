@extends('layouts.app')
@section('content')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

    <div class="container">
        <h3>Vacations & Outings</h3>

        <table class="table table-bordered" id="vacations-table">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Type</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                {{-- @forelse($vacations as $v)
                    <tr>
                        <td>{{ $v->title }}</td>
                        <td><span class="badge bg-info">{{ ucfirst($v->type) }}</span></td>
                        <td>{{ \Carbon\Carbon::parse($v->start_date)->format('M d, Y') }}</td>
                        <td>{{ $v->end_date ? \Carbon\Carbon::parse($v->end_date)->format('M d, Y') : '-' }}</td>
                        <td>
                            <a href="{{ route('familyMember.events.show', $v->id) }}" class="btn btn-sm btn-primary">View</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">No vacations or outings assigned.</td>
                    </tr>
                @endforelse --}}
            </tbody>
        </table>
    </div>
@endsection

@push('js')
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <script>
        $(function() {
            $('#vacations-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('familyMember.events.index') }}",
                columns: [{
                        data: 'title',
                        name: 'title'
                    },
                    {
                        data: 'type',
                        name: 'type',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'start_date',
                        name: 'start_date'
                    },
                    {
                        data: 'end_date',
                        name: 'end_date'
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
