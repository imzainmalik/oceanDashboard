<!DOCTYPE html>
<html lang="en">

<head>
    @include('layouts.caregiver.includes.compatibility')
    <meta name="description" content="">
    <title> CAREGIVER </title>
    @include('layouts.caregiver.includes.style')
</head>

<body>

    <div class="page-box">
        @include('layouts.caregiver.includes.sidebar')
        <div class="main-content">
            @include('layouts.caregiver.includes.header')
            <div class="content-card">
                <div class="container-fluid p-0">
                    <div class="page-title">
                        <div class="row align-items-center">
                            <div class="col-md-5">
                                <div class="content">
                                    <h3>Senior Dashboard</h3>
                                </div>
                            </div>
                            <div class="col-md-7 text-md-end">
                                <div class="addBtns">
                                    <a href="javascript:;" class="btn btn-secondary"><i class="fab fa-plus"></i> Add
                                        Information</a>
                                    <a href="javascript:;" class="btn btn-secondary" data-bs-toggle="modal"
                                        data-bs-target="#staticBackdrop"><i class="fab fa-plus"></i> Add
                                        Task</a>
                                    <a href="javascript:;" class="btn btn-secondary"><i class="fab fa-plus"></i> Add
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
                                        <div class="col-md-4 text-md-end">

                                            <div class="btn-group btnIconDetail">
                                                <button type="button" class="dropdown-toggle" data-bs-toggle="dropdown"
                                                    data-bs-display="static" aria-expanded="false">
                                                    <i class="fas fa-ellipsis-h"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-start dropdown-menu-lg-start">
                                                    <li><a class="dropdown-item" href="#">Select</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="profile-card">
                                            <img src="{{ asset('caregiver/assets/images/profile.png') }}"
                                                alt="">
                                            <h6>Jake Vincent</h6>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="profile-border-card">
                                            <div class="img">
                                                <img src="{{ asset('caregiver/assets/images/eo1.png') }}"
                                                    alt="">
                                            </div>
                                            <div class="txt">
                                                <span> Gender </span>
                                                <p>Male</p>
                                            </div>

                                        </div>

                                        <div class="profile-border-card">
                                            <div class="img">
                                                <img src="{{ asset('caregiver/assets/images/eo2.png') }}"
                                                    alt="">
                                            </div>
                                            <div class="txt">
                                                <span> Age </span>
                                                <p>67 y.o.</p>
                                            </div>

                                        </div>

                                        <div class="profile-border-card">
                                            <div class="img">
                                                <img src="{{ asset('caregiver/assets/images/eo3.png') }}"
                                                    alt="">
                                            </div>
                                            <div class="txt">
                                                <span> Blood Type </span>
                                                <p>B</p>
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

                                        <div class="col-md-2 text-md-end">
                                            <select class="form-control daySelect">
                                                <option>Today</option>
                                            </select>
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
                                                    <tr>
                                                        <td>
                                                            <div class="user"><img
                                                                    src="{{ asset('caregiver/assets/images/rs1.png') }}"
                                                                    alt="">
                                                                <p>Jason Herwitz</p>
                                                            </div>
                                                        </td>
                                                        <td> Bathing </td>
                                                        <td> <span class="date">11-7-2025</span> </td>
                                                        <td> <span class="badge-table badge-green">Accepted</span> </td>
                                                        <td class="text-center">
                                                            <div class="btn-group btnIconDetail">
                                                                <button type="button" class="dropdown-toggle"
                                                                    data-bs-toggle="dropdown" data-bs-display="static"
                                                                    aria-expanded="false">
                                                                    <i class="fas fa-ellipsis-h"></i>
                                                                </button>
                                                                <ul class="dropdown-menu">
                                                                    <li><a class="dropdown-item"
                                                                            href="#">Edit</a></li>
                                                                    <li><a class="dropdown-item"
                                                                            href="#">Delete</a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td>
                                                            <div class="user"><img
                                                                    src="{{ asset('caregiver/assets/images/rs2.png') }}"
                                                                    alt="">
                                                                <p>Mira Dokidis</p>
                                                            </div>
                                                        </td>
                                                        <td> Feeding </td>
                                                        <td> <span class="date"> 11-7-2025 </span> </td>
                                                        <td> <span class="badge-table badge-purple">Unread</span> </td>
                                                        <td class="text-center">
                                                            <div class="btn-group btnIconDetail">
                                                                <button type="button" class="dropdown-toggle"
                                                                    data-bs-toggle="dropdown" data-bs-display="static"
                                                                    aria-expanded="false">
                                                                    <i class="fas fa-ellipsis-h"></i>
                                                                </button>
                                                                <ul class="dropdown-menu">
                                                                    <li><a class="dropdown-item"
                                                                            href="#">Edit</a></li>
                                                                    <li><a class="dropdown-item"
                                                                            href="#">Delete</a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td>
                                                            <div class="user"><img
                                                                    src="{{ asset('caregiver/assets/images/rs3.png') }}"
                                                                    alt="">
                                                                <p>Anika Korsgaard</p>
                                                            </div>
                                                        </td>
                                                        <td> Toileting </td>
                                                        <td> <span class="date"> 11-7-2025 </span> </td>
                                                        <td> <span class="badge-table badge-red">Declined</span>
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
                                                                            href="#">Edit</a></li>
                                                                    <li><a class="dropdown-item"
                                                                            href="#">Delete</a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td>
                                                            <div class="user"><img
                                                                    src="{{ asset('caregiver/assets/images/rs4.png') }}"
                                                                    alt="">
                                                                <p>Zaire Rhiel Madsen</p>
                                                            </div>
                                                        </td>
                                                        <td> Medication </td>
                                                        <td> <span class="date"> 11-7-2025</span> </td>
                                                        <td> <span
                                                                class="badge-table badge-yellow">Seen/No-Response</span>
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
                                                                            href="#">Edit</a></li>
                                                                    <li><a class="dropdown-item"
                                                                            href="#">Delete</a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </td>
                                                    </tr>

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

                                        <div class="col-md-2 text-md-end">
                                            <select class="form-control daySelect">
                                                <option>Today</option>
                                            </select>
                                        </div>

                                        <div class="col-md-1 text-md-center">

                                            <div class="btn-group btnIconDetail">
                                                <button type="button" class="dropdown-toggle"
                                                    data-bs-toggle="dropdown" data-bs-display="static"
                                                    aria-expanded="false">
                                                    <i class="fas fa-ellipsis-h"></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item" href="#">Select</a></li>
                                                </ul>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="orderTable table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th> Task </th>
                                                <th> Assigned To </th>
                                                <th> Assigned On </th>
                                                <th> Status </th>
                                                <th> </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>

                                                <td> Bathing </td>

                                                <td>
                                                    Jason Herwitz
                                                </td>

                                                <td> <span class="date">11-7-2025</span> </td>
                                                <td> <span class="badge-table badge-green">Accepted</span> </td>
                                                <td class="text-center">
                                                    <div class="btn-group btnIconDetail">
                                                        <button type="button" class="dropdown-toggle"
                                                            data-bs-toggle="dropdown" data-bs-display="static"
                                                            aria-expanded="false">
                                                            <i class="fas fa-ellipsis-h"></i>
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            <li><a class="dropdown-item" href="#">Edit</a></li>
                                                            <li><a class="dropdown-item" href="#">Delete</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td> Feeding </td>
                                                <td>
                                                    Mira Dokidis
                                                </td>
                                                <td> <span class="date"> 11-7-2025 </span> </td>
                                                <td> <span class="badge-table badge-purple">Unread</span> </td>
                                                <td class="text-center">
                                                    <div class="btn-group btnIconDetail">
                                                        <button type="button" class="dropdown-toggle"
                                                            data-bs-toggle="dropdown" data-bs-display="static"
                                                            aria-expanded="false">
                                                            <i class="fas fa-ellipsis-h"></i>
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            <li><a class="dropdown-item" href="#">Edit</a></li>
                                                            <li><a class="dropdown-item" href="#">Delete</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>
                                                    Anika Korsgaard
                                                </td>
                                                <td> Toileting </td>
                                                <td> <span class="date"> 11-7-2025 </span> </td>
                                                <td> <span class="badge-table badge-red">Declined</span>
                                                </td>
                                                <td class="text-center">
                                                    <div class="btn-group btnIconDetail">
                                                        <button type="button" class="dropdown-toggle"
                                                            data-bs-toggle="dropdown" data-bs-display="static"
                                                            aria-expanded="false">
                                                            <i class="fas fa-ellipsis-h"></i>
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            <li><a class="dropdown-item" href="#">Edit</a></li>
                                                            <li><a class="dropdown-item" href="#">Delete</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td> Medication </td>
                                                <td>
                                                    Zaire Rhiel Madsen
                                                </td>

                                                <td> <span class="date"> 11-7-2025</span> </td>
                                                <td> <span class="badge-table badge-yellow">Seen/No-Response</span>
                                                </td>
                                                <td class="text-center">
                                                    <div class="btn-group btnIconDetail">
                                                        <button type="button" class="dropdown-toggle"
                                                            data-bs-toggle="dropdown" data-bs-display="static"
                                                            aria-expanded="false">
                                                            <i class="fas fa-ellipsis-h"></i>
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            <li><a class="dropdown-item" href="#">Edit</a></li>
                                                            <li><a class="dropdown-item" href="#">Delete</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>

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
                                                <button type="button" class="dropdown-toggle"
                                                    data-bs-toggle="dropdown" data-bs-display="static"
                                                    aria-expanded="false">
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
                                                    <button type="button" class="dropdown-toggle"
                                                        data-bs-toggle="dropdown" data-bs-display="static"
                                                        aria-expanded="false">
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
                                                    <button type="button" class="dropdown-toggle"
                                                        data-bs-toggle="dropdown" data-bs-display="static"
                                                        aria-expanded="false">
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
                                                    <button type="button" class="dropdown-toggle"
                                                        data-bs-toggle="dropdown" data-bs-display="static"
                                                        aria-expanded="false">
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
                                                    <button type="button" class="dropdown-toggle"
                                                        data-bs-toggle="dropdown" data-bs-display="static"
                                                        aria-expanded="false">
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
                                                    <button type="button" class="dropdown-toggle"
                                                        data-bs-toggle="dropdown" data-bs-display="static"
                                                        aria-expanded="false">
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
        </div>

    </div>

    @include('layouts.caregiver.includes.scripts')

</body>

</html>
