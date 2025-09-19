@extends('layouts.app')
@section('content')
    <div class="content-card">
        <div class="container-fluid p-0">
            <div class="page-title">
                <div class="row align-items-center">
                    <div class="col-md-5">
                        <div class="content">
                            <h3>Family owner Dashboard</h3>
                        </div>
                    </div>
                    <div class="col-md-7 text-md-end">
                        <div class="addBtns">
                            <a href="javascript:;" class="btn btn-secondary"><i class="fab fa-plus"></i> Add
                                Information</a>
                            <a href="{{ route('familyOwner.tasks.index') }}" class="btn btn-secondary"
                                data-bs-toggle="modal" data-bs-target="#staticBackdrop"><i class="fab fa-plus"></i> Add
                                Task</a>
                            <a href="{{ route('familyOwner.add_member') }}" class="btn btn-secondary"><i
                                    class="fab fa-plus"></i> Add
                                Member</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="primary-card overview-card">
                        <div class="primary-card-header">
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <h5>Elder’s Overview</h5>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="profile-card">
                                    <img src="{{ asset('display_picture/' . $senior->user->d_pic) }}" alt="">
                                    <h6>{{ $senior->user->name }}</h6>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="profile-border-card">
                                    <div class="img">
                                        <img src="{{ asset('caregiver/assets/images/eo1.png') }}" alt="">
                                    </div>
                                    <div class="txt">
                                        <span> Gender </span>
                                        <p>{{ $senior->gender }}</p>
                                    </div>

                                </div>

                                <div class="profile-border-card">
                                    <div class="img">
                                        <img src="{{ asset('caregiver/assets/images/eo2.png') }}" alt="">
                                    </div>
                                    <div class="txt">
                                        <span> Age </span>
                                        <p>{{ Carbon\Carbon::parse($senior->dob)->age }} y.o.</p>
                                    </div>

                                </div>

                                <div class="profile-border-card">
                                    <div class="img">
                                        <img src="{{ asset('caregiver/assets/images/eo3.png') }}" alt="">
                                    </div>
                                    <div class="txt">
                                        <span> Blood Type </span>
                                        <p>{{ $senior->blood_type }}</p>
                                    </div>

                                </div>

                            </div>

                        </div>

                        <div class="seeMore">
                            <a href="javascript:;" class="btn btn-secondary">See all information</a>
                        </div>

                    </div>
                </div>

                <div class="col-md-8">
                    <div class="primary-card request-card">
                        <div class="primary-card-header">
                            <div class="row">
                                <div class="col-md-9">
                                    <h5>Request & Response</h5>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="orderTable table-responsive">
                                    <table class="table">

                                        <thead>
                                            <tr>
                                                <th> Name </th>
                                                <th> Task </th>
                                                <th> Assigned On </th>
                                                <th> Status </th>
                                                <th> </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($requests as $task)
                                                <tr>
                                                    <td>
                                                        <div class="user">
                                                            <img src="{{ $task->assignee->d_pic
                                                                ? asset('display_picture/' . $task->assignee->d_pic)
                                                                : asset('caregiver/assets/images/default.png') }}"
                                                                alt="">
                                                            <p>{{ $task->assignee->name }}</p>
                                                        </div>
                                                    </td>
                                                    <td>{{ $task->title }}</td>
                                                    <td><span
                                                            class="date">{{ $task->created_at->format('d-m-Y') }}</span>
                                                    </td>
                                                    <td>
                                                        @php
                                                            $statusColors = [
                                                                'accepted' => 'badge-green',
                                                                'unread' => 'badge-purple',
                                                                'declined' => 'badge-red',
                                                                'seen_no_response' => 'badge-yellow',
                                                                'pending' => 'badge-gray',
                                                            ];
                                                        @endphp
                                                        <span
                                                            class="badge-table {{ $statusColors[$task->status] ?? 'badge-gray' }}">
                                                            {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                                                        </span>
                                                    </td>
                                                    <td class="text-center">
                                                        <div class="btn-group btnIconDetail">
                                                            <button type="button" class="dropdown-toggle"
                                                                data-bs-toggle="dropdown" data-bs-display="static"
                                                                aria-expanded="false">
                                                                <i class="fas fa-ellipsis-h"></i>
                                                            </button>
                                                            <ul class="dropdown-menu">
                                                                <li><a class="dropdown-item"
                                                                        href="{{ route('familyOwner.tasks.edit', $task->id) }}">Edit</a>
                                                                </li>
                                                                <li><a class="dropdown-item" href="javascript:;"
                                                                        onclick="deleteTask({{ $task->id }})">Delete</a>

                                                                        <form method=""></form>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="5" class="text-center text-muted">No requests found.
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>

            <div class="row">

                <div class="col-md-8">
                    <div class="primary-card">
                        <div class="primary-card-header">
                            <div class="row">
                                <div class="col-md-9">
                                    <h5>Assigned Roles Tracker</h5>
                                </div>
                            </div>
                        </div>
                        <div class="orderTable table-responsive">
                            <table class="table">
                                <tbody>
                                    @forelse($requests as $task)
                                        <tr>
                                            <td>{{ $task->title }}</td>

                                            <td>{{ $task->assignee->name ?? 'Unassigned' }}</td>

                                            <td><span class="date">{{ $task->created_at->format('d-m-Y') }}</span></td>

                                            <td>
                                                @php
                                                    $statusColors = [
                                                        'accepted' => 'badge-green',
                                                        'unread' => 'badge-purple',
                                                        'declined' => 'badge-red',
                                                        'seen_no_response' => 'badge-yellow',
                                                        'pending' => 'badge-gray',
                                                    ];
                                                @endphp
                                                <span
                                                    class="badge-table {{ $statusColors[$task->status] ?? 'badge-gray' }}">
                                                    {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                                                </span>
                                            </td>

                                            <td class="text-center">
                                                <div class="btn-group btnIconDetail">
                                                    <button type="button" class="dropdown-toggle" data-bs-toggle="dropdown"
                                                        data-bs-display="static" aria-expanded="false">
                                                        <i class="fas fa-ellipsis-h"></i>
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li><a class="dropdown-item"
                                                                href="{{ route('familyOwner.tasks.edit', $task->id) }}">Edit</a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item" href="javascript:;"
                                                                onclick="deleteTask({{ $task->id }})">Delete</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center text-muted">No tasks available.</td>
                                        </tr>
                                    @endforelse
                                </tbody>

                            </table>

                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="primary-card family-card">
                        <div class="primary-card-header">
                            <div class="row">
                                <div class="col-md-11">
                                    <h5>Family Notes & Feedback</h5>
                                </div>

                                <div class="col-md-1 text-md-center">

                                    <div class="btn-group btnIconDetail">
                                        <button type="button" class="dropdown-toggle" data-bs-toggle="dropdown"
                                            data-bs-display="static" aria-expanded="false">
                                            <i class="fas fa-ellipsis-h"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="#">Select</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="primary-card-body">
                            <div class="notes">
                                <div class="row">
                                    <div class="col-md-11">
                                        <p>Sed ut sed pellentesque imperdiet commodo elit.</p>
                                    </div>

                                    <div class="col-md-1 text-md-center">
                                        <div class="btn-group btnIconDetail">
                                            <button type="button" class="dropdown-toggle" data-bs-toggle="dropdown"
                                                data-bs-display="static" aria-expanded="false">
                                                <i class="fas fa-ellipsis-h"></i>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="#">Select</a></li>
                                            </ul>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="notes">
                                <div class="row">
                                    <div class="col-md-11">
                                        <p> Euismod neque suspendisse sed convallis et. </p>
                                    </div>

                                    <div class="col-md-1 text-md-center">
                                        <div class="btn-group btnIconDetail">
                                            <button type="button" class="dropdown-toggle" data-bs-toggle="dropdown"
                                                data-bs-display="static" aria-expanded="false">
                                                <i class="fas fa-ellipsis-h"></i>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="#">Select</a></li>
                                            </ul>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="notes">
                                <div class="row">
                                    <div class="col-md-11">
                                        <p> Quis turpis enim libero amet etnascetur. </p>
                                    </div>

                                    <div class="col-md-1 text-md-center">
                                        <div class="btn-group btnIconDetail">
                                            <button type="button" class="dropdown-toggle" data-bs-toggle="dropdown"
                                                data-bs-display="static" aria-expanded="false">
                                                <i class="fas fa-ellipsis-h"></i>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="#">Select</a></li>
                                            </ul>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="notes">
                                <div class="row">
                                    <div class="col-md-11">
                                        <p> Feugiat pulvinar fringilla ut nibh ultricies dictum. </p>
                                    </div>

                                    <div class="col-md-1 text-md-center">
                                        <div class="btn-group btnIconDetail">
                                            <button type="button" class="dropdown-toggle" data-bs-toggle="dropdown"
                                                data-bs-display="static" aria-expanded="false">
                                                <i class="fas fa-ellipsis-h"></i>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="#">Select</a></li>
                                            </ul>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="notes">
                                <div class="row">
                                    <div class="col-md-11">
                                        <p> Euismod neque suspendisse sed convallis et. </p>
                                    </div>

                                    <div class="col-md-1 text-md-center">
                                        <div class="btn-group btnIconDetail">
                                            <button type="button" class="dropdown-toggle" data-bs-toggle="dropdown"
                                                data-bs-display="static" aria-expanded="false">
                                                <i class="fas fa-ellipsis-h"></i>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="#">Select</a></li>
                                            </ul>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>

        </div>
    </div>
@endsection
@push('js')
    <script>
        function deleteTask(id) {
            Swal.fire({
                title: 'Warning!',
                text: 'This action can\'t be undone.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        }
    </script>
@endpush
