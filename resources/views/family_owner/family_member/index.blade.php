@extends('layouts.app')
@section('content')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

    <div class="page-box py-4">
        <div class="card">
            <div class="card-header">
                All Members
            </div>
                            <a href="{{ route('familyOwner.add_member') }}">Create Mmebers</a>

            <div class="card-body">
                <div class="row" bis_skin_checked="1">
                    <div class="col-lg-12" bis_skin_checked="1">
                        <div class="orderTable" bis_skin_checked="1">
                            <table class="table" id="members-table">
                                <thead>
                                    <tr>
                                        <th> Name </th>
                                        <th> Email </th>
                                        <th> Permissions </th>
                                        <th> Completed Task </th>
                                        <th> Account status </th>
                                        <th> Action</th>
                                        {{-- <th> </th> --}}
                                    </tr>
                                </thead>

                            </table>
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
            $('#members-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('familyOwner.all_members') }}", // route pointing to controller
                columns: [{
                        data: 'user',
                        name: 'user'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'permissions',
                        name: 'permissions',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'status',
                        name: 'status',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'acc_status',
                        name: 'acc_status',
                        orderable: false,
                        searchable: false
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

        function delete_member(id) {
            Swal.fire({
                title: 'Warning!',
                text: 'This action can\'t be undone.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',

            }).then((result) => {
                if (result.isConfirmed) {
                    // Redirect to delete route
                    window.location.href = "/familyOwner/delete-member/" + id;
                    // OR with Laravel named route:
                    // window.location.href = "{{ url('users/delete') }}/" + userId;
                }
            });
        }


        function inactivate_member(id) {
            Swal.fire({
                title: 'Info!',
                text: 'User can\'t logged in again unless you not set them active again.',
                icon: 'info',
                showCancelButton: true,
                confirmButtonText: 'Yes, DeActivate it!',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',

            }).then((result) => {
                if (result.isConfirmed) {
                    // Redirect to delete route
                    window.location.href = "/familyOwner/delete-member/" + id +"?status=1";
                    // OR with Laravel named route:
                    // window.location.href = "{{ url('users/delete') }}/" + userId;
                }
            });
        }

        function activate_member(id) {
            Swal.fire({
                title: 'Info!',
                text: 'User could logged in again unless you not set them Inactive.',
                icon: 'info',
                showCancelButton: true,
                confirmButtonText: 'Yes, Activate it!',
                cancelButtonText: 'Cancel',
                confirmButtonColor: 'rgba(51, 221, 88, 1)',
                cancelButtonColor: '#6c757d',

            }).then((result) => {
                if (result.isConfirmed) {
                    // Redirect to delete route
                    window.location.href = "/familyOwner/activate-member/" + id+"?status=0";
                    // OR with Laravel named route:
                    // window.location.href = "{{ url('users/delete') }}/" + userId;
                }
            });
        }
    </script>
@endpush
