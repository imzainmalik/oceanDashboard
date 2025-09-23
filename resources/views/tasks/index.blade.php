@extends('layouts.app')

@section('content')
    <div class="content-card" bis_skin_checked="1">
        <div class="container-fluid p-0" bis_skin_checked="1">
            <div class="page-title" bis_skin_checked="1">
                <div class="row align-items-center" bis_skin_checked="1">
                    
                    <div class="col-md-7 text-md-end" bis_skin_checked="1">
                        <div class="addBtns" bis_skin_checked="1">
                            {{-- <a href="javascript:;" class="btn btn-secondary"><i class="fab fa-plus"></i> Add
                                Information</a> --}}
                            <a href="{{ route('familyOwner.tasks.create') }}" class="btn btn-secondary"><i class="fab fa-plus"></i> Add
                                Task</a>
                            <a href="{{ route('familyOwner.add_member') }}" class="btn btn-secondary"><i class="fab fa-plus"></i> Add
                                Member</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row" bis_skin_checked="1">
                <div class="col-md-8" bis_skin_checked="1">
                    <div class="primary-card request-card" bis_skin_checked="1"> 
                        <div class="row" bis_skin_checked="1">
                            <div class="col-lg-12" bis_skin_checked="1">
                                <div class="orderTable table-responsive" bis_skin_checked="1">
                                    <table class="table table-bordered" id="tasks-table">
                                        <thead>
                                            <tr>
                                                <th>Title</th>
                                                <th>Type</th>
                                                <th>Owner</th>
                                                <th>Assignee</th>
                                                <th>Status</th>
                                                <th width="150">Actions</th>
                                            </tr>
                                        </thead>
                                    </table>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="col-md-4" bis_skin_checked="1">
                    <div class="primary-card messages-card" bis_skin_checked="1">
                        <div class="primary-card-header" bis_skin_checked="1">
                            <div class="row" bis_skin_checked="1">
                                <div class="col-md-11" bis_skin_checked="1">
                                    <h5>Messages</h5>
                                </div> 
                            </div>
                        </div>

                        <div class="primary-card-body" bis_skin_checked="1">

                            <div class="messages" bis_skin_checked="1">
                                <img src="assets/images/av1.png" alt="">
                                <p>Harold Bridges<br> <span> Thank you!</span></p>
                                <span class="badgeNumber">2</span>
                            </div>

                          

                            <div class="messages" bis_skin_checked="1">
                                <img src="assets/images/av8.png" alt="">
                                <p> Chase Fisher <br> <span> </span></p>
                            </div>

                        </div>

                    </div>
                </div>

            </div>

        </div>
    </div>
@endsection

@push('js')
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(function() {
            $('#tasks-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('familyOwner.tasks.index') }}",
                columns: [{
                        data: 'title',
                        name: 'title'
                    },
                    {
                        data: 'type',
                        name: 'type'
                    },
                    {
                        data: 'owner',
                        name: 'owner'
                    },
                    {
                        data: 'assignee',
                        name: 'assignee'
                    },
                    {
                        data: 'status',
                        name: 'status',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'actions',
                        name: 'actions',
                        orderable: false,
                        searchable: false
                    }
                ]
            });
        });
    </script>
@endpush
