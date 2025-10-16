<header>
    <div class="main-header">
        <button class="btnToggle"><i class="fal fa-chevron-left"></i></button>
        <div class="container-fluid p-0">
            <div class="row align-items-center">

                <div class="col-lg-5">
                    <div class="desc">
                        <h3> Good Morning </h3>
                        <p> Good morning! Hope you feel better today. </p>
                    </div>

                </div>

                <div class="col-lg-7 text-center text-md-end">
                    <div class="header-right">
                        <ul class="notificationList">
                            <li>
                                <a href="javascript:;"><i class="fal fa-bell"></i>
                                    <!-- <span class="badge-icon">12</span> -->
                                </a>
                            </li>
                            <li>
                                <a href="javascript:;"><i class="fal fa-comment-alt-dots"></i>
                                    <!-- <span class="badge-icon">06</span> -->
                                </a>
                            </li>
                        </ul>
                        <div class="user-dropdown">
                            <div class="user-avatar" id="userAvatar">
                                <img src="assets/images/avator.png" alt="" />
                                <div class="txt">
                                    <p class="p1"><span class="name">Debi Clark</span></p>
                                </div>
                            </div>
                            <div class="dropdown-content" id="dropdownContent">
                                <a href="#" onclick="document.getElementById('logout-form').submit();">Logout</a>
                                <form method="post" id="logout-form" action="{{ route('logout') }}">
                                    @csrf
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</header>

<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered ">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Tasks list</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul class="statusList">
                    <li>
                        <span class="circle circle-green"></span>
                        <span>Work</span>
                    </li>

                    <li>
                        <span class="circle circle-orange"></span>
                        <span>Travel</span>
                    </li>

                    <li>
                        <span class="circle circle-blue"></span>
                        <span>Family</span>
                    </li>

                    <li>
                        <span class="circle circle-purple"></span>
                        <span>Other</span>
                    </li>

                </ul>

                <div class="statusTxt">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox">
                        <label class="form-check-label">
                            Book flights to Seattle <br>
                            <span>29 Jul 2019 / 03:23PM</span>
                        </label>
                        <span class="statusBadge statusBadgeOrange"></span>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox">
                        <label class="form-check-label">
                            Finish appointment <br>
                            <span> 26 Aug 2019 / 11:12PM</span>
                        </label>
                        <span class="statusBadge statusBadgeGreen"></span>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox">
                        <label class="form-check-label">
                            Visit Global Gym <br>
                            <span> 28 Dec 2019 / 08:03PM</span>
                        </label>
                        <span class="statusBadge statusBadgePurple"></span>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox">
                        <label class="form-check-label">
                            Medical conference <br>
                            <span> 14 Jun 2019 / 01:05PM</span>
                        </label>
                        <span class="statusBadge statusBadgeGreen"></span>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox">
                        <label class="form-check-label">
                            Buy medicine for Aron <br>
                            <span> 14 Jun 2019 / 01:05PM</span>
                        </label>
                        <span class="statusBadge statusBadgeBlue"></span>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox">
                        <label class="form-check-label">
                            Regular dentist checkup <br>
                            <span> 22 Jun 2019 / 08:48PM</span>
                        </label>
                        <span class="statusBadge statusBadgeGreen"></span>
                    </div>
   
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox">
                        <label class="form-check-label">
                            Book flights to London meetup <br>
                            <span>05 Apr 2019 / 11:14AM </span>
                        </label>
                        <span class="statusBadge statusBadgeOrange"></span>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox">
                        <label class="form-check-label">
                            Long running training <br>
                            <span> 16 Dec 2019 / 09:03AM</span>
                        </label>
                        <span class="statusBadge statusBadgePurple"></span>
                    </div>

                    <a href="javascript:;" class="btn btn-secondary w-100">Add new task</a>

                </div>

            </div>

        </div>
    </div>
</div>


<div class="modal fade edit-form" id="form" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header border-bottom-0">
                <h5 class="modal-title" id="modal-title">Add Event</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="myForm">
                <div class="modal-body">
                    <div class="alert alert-danger " role="alert" id="danger-alert" style="display: none;">
                        End date should be greater than start date.
                    </div>
                    <div class="form-group">
                        <label for="event-title">Event name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="event-title" placeholder="Enter event name"
                            required>
                    </div>
                    <div class="form-group">
                        <label for="start-date">Start date <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" id="start-date" placeholder="start-date" required>
                    </div>
                    <div class="form-group">
                        <label for="end-date">End date - <small class="text-muted">Optional</small></label>
                        <input type="date" class="form-control" id="end-date" placeholder="end-date">
                    </div>
                    <div class="form-group">
                        <label for="event-color">Color</label>
                        <input type="color" class="form-control" id="event-color" value="#3788d8">
                    </div>
                </div>
                <div class="modal-footer border-top-0 d-flex justify-content-center">
                    <button type="submit" class="btn btn-success" id="submit-button">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Delete Modal -->
<!-- <div class="modal fade" id="delete-modal" tabindex="-1" role="dialog" aria-labelledby="delete-modal-title"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="delete-modal-title">Confirm Deletion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center" id="delete-modal-body">
                Are you sure you want to delete the event?
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-secondary rounded-sm" data-dismiss="modal"
                    id="cancel-button">Cancel</button>
                <button type="button" class="btn btn-danger rounded-lg" id="delete-button">Delete</button>
            </div>
        </div>
    </div>
</div> -->