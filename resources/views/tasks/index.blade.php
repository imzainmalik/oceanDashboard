@extends('layouts.app')

@section('content')
    {{-- @dd(auth()->user()->role); --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    {{-- @dd('sss'); --}}
    <div class="content-card" bis_skin_checked="1">
        <div class="container-fluid p-0" bis_skin_checked="1">
            <div class="page-title" bis_skin_checked="1">
                <div class="row align-items-center" bis_skin_checked="1">
                    <div class="col-md-5" bis_skin_checked="1">
                                <div class="content" bis_skin_checked="1">
                                    <h3>All Tasks</h3>
                                </div>
                            </div>
                    @if (auth()->user()->role->id == 4)
                        <div class="col-md-7 text-md-end" bis_skin_checked="1">
                            <div class="addBtns" bis_skin_checked="1">
                                {{-- <a href="javascript:;" class="btn btn-secondary"><i class="fab fa-plus"></i> Add
                                Information</a> --}}
                                <a href="{{ route('familyOwner.tasks.create') }}" class="btn btn-secondary"><i
                                        class="fab fa-plus"></i> Add
                                    Task</a>
                                <a href="{{ route('familyOwner.add_member') }}" class="btn btn-secondary"><i
                                        class="fab fa-plus"></i> Add
                                    Member</a>
                            </div>
                        </div>
                    @endif
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
                                                <th>Name</th>
                                                <th>Task</th>
                                                <th>Assigned On</th>
                                                <th>Status</th>
                                                <th>Actions</th>
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
                                <img src="{{ asset('family_owner/assets/images/av1.png') }}" alt="">
                                <p>Harold Bridges<br> <span> Thank you!</span></p>
                                <span class="badgeNumber">2</span>
                            </div>



                            <div class="messages" bis_skin_checked="1">
                                <img src="{{ asset('family_owner/assets/images/av8.png') }}" alt="">
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
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <script>
        $(function() {
            $('#tasks-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('familyOwner.tasks.index') }}",
                columns: [{
                        data: 'name',
                        name: 'name',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'task',
                        name: 'task',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'assigned_on',
                        name: 'assigned_on',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'status',
                        name: 'status',
                        orderable: true,
                        searchable: true
                    },
                    { 
                        data: 'actions', 
                        name: 'actions', 
                        orderable: false, 
                        searchable: false  
                    }
                ]
            });



            // Live update countdown every second
            setInterval(function() {
                $('#tasks-table .countdown').each(function() {
                    let deadline = new Date($(this).data('deadline'));
                    let now = new Date();
                    let diff = deadline - now;

                    if (diff <= 0) {
                        $(this).text("Expired / Need Help").css("color", "red");
                    } else {
                        let hours = Math.floor(diff / (1000 * 60 * 60));
                        let minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
                        let seconds = Math.floor((diff % (1000 * 60)) / 1000);

                        // Color coding
                        let color = hours > 24 ? "green" : (hours > 1 ? "orange" : "red");
                        $(this).text(hours + "h " + minutes + "m " + seconds + "s").css("color",
                            color);
                    }
                });
            }, 1000);
        });
    </script>
@endpush
