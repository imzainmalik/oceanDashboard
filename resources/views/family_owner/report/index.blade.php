@extends('layouts.app')

@section('content')
    <style>
        .fade:not(.show) {
            opacity: 1;
        }

        /* div#download_monthly {
                background-color: #0c0c0c9c;
            } */
    </style>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <br>
    <div class="row">
        <div class="col-2">
            <button type="button" data-toggle="modal" data-target="#download_monthly" class="btn btn-primary">Download
                Report</button>
        </div>
        <div class="col-6">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#download_member_report">Download
                Member Report</button>
        </div>
    </div>
    <br>
    <div class="card">
        <div class="secondary-card-header">
            All time Report
        </div>
        <div class="card-body">
            <table class="table table-bordered" id="reports-table">
                <thead>
                    <tr>
                        <th>Member</th>
                        <th>Total Tasks</th>
                        <th>Completed</th>
                        <th>Pending</th>
                        <th>Cancelled</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    @php
    
        $tenant = App\Models\Tenant::where('child_id', auth()->user()->id)->first();
        // dd($tenant);
        if ($tenant != null) {
            $ownerId = $tenant->owner_id;
        } else {
            $ownerId = auth()->user()->id;
        }
        $members = \App\Models\Tenant::with([
            'users' => function ($query) {
                $query->where('account_status', 0);
            },
        ])
            ->where('owner_id', $ownerId)
            ->get();
    @endphp
    <div class="modal fade" id="download_member_report" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="get" action="{{ route(auth()->user()->custom_role.'.download_report') }}">
                        <div class="row">
                            <div class="col-12">
                                <label>Select Member</label>
                                <select name="member" class="form-control" required>
                                    <option value="" selected disabled>Select Member</option>
                                    @foreach ($members as $member)
                                        <option value="{{ $member->users->id }}">{{ $member->users->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-6">
                                <label>Start date</label>
                                <input type="date" name="start_date" class="form-control" required />
                            </div>

                            <div class="col-6">
                                <label>End date</label>
                                <input type="date" name="end_date" class="form-control" required />
                            </div>
                            <button type="submit" class="btn btn-primary">Download</button>
                        </div>
                    </form>
                </div>
                {{-- <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div> --}}
            </div>
        </div>
    </div>


    <div class="modal fade" id="download_monthly" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="get" action="{{ route(auth()->user()->custom_role.'.download_report') }}">
                        <div class="row">
                            <div class="col-6">
                                <label>Start date</label>
                                <input type="date" name="start_date" class="form-control" required />
                            </div>

                            <div class="col-6">
                                <label>End date</label>
                                <input type="date" name="end_date" class="form-control" required />
                            </div>
                            <button type="submit" class="btn btn-primary">Download</button>
                        </div>
                    </form>
                </div>
                {{-- <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div> --}}
            </div>
        </div>
    </div>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <script>
        $(function() {
            $('#reports-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route(auth()->user()->custom_role.'.report.index') }}',
                columns: [{
                        data: 'member',
                        name: 'member',
                        searchable: true
                    },
                    {
                        data: 'total_tasks',
                        name: 'total_tasks',
                        searchable: true
                    },
                    {
                        data: 'completed_tasks',
                        name: 'completed_tasks',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'pending_tasks',
                        name: 'pending_tasks',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'cancelled_tasks',
                        name: 'cancelled_tasks',
                        orderable: false,
                        searchable: false
                    },
                ]
            });
        });

        $('#reports-table thead tr:eq(1) th').each(function(i) {
            $('input', this).on('keyup change', function() {
                if (table.column(i).search() !== this.value) {
                    table
                        .column(i)
                        .search(this.value)
                        .draw();
                }
            });
        });
    </script>
@endpush
