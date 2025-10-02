<div class="sidebar-wrapper scrollbar scrollbar-inner">
    <div class="sidebar">
        <nav>
            <!-- Logo -->
            <a href="{{ route('caregiver.index') }}" class="logo text-dark w-100">
                <img src="{{ asset('caregiver/assets/images/logo01.png') }}" alt="Logo">
            </a>

            <div class="navBottom">

                <!-- Search -->
                <div class="search">
                    <button><i class="fal fa-search"></i></button>
                    <input type="text" placeholder="Search">
                </div>
                    {{-- @dd(auth()->user()->hasPermission('emergency_protocol')); --}}
                <!-- Main Navigation -->
                <ul class="navbar-nav w-100">

                    <span class="subNav">General</span>

                    <li>
                        <a href="{{ route('caregiver.index') }}" class="nav-item nav-link">
                            <img src="{{ asset('caregiver/assets/images/menu-icon1.svg') }}" alt="">
                            Overview
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('caregiver.daily-updates.index') }}" class="nav-item nav-link">
                            <img src="{{ asset('caregiver/assets/images/menu-icon2.svg') }}" alt="">
                            Activity Timeline
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('caregiver.tasks.index') }}" class="menu-item nav-item nav-link">
                            <img src="{{ asset('caregiver/assets/images/menu-icon3.svg') }}" alt="">
                            Requests & Responses
                        </a>
                    </li>


                    <li>
                        <a href="{{ route('caregiver.family-notes.index') }}" class="nav-item nav-link">
                            <img src="{{ asset('caregiver/assets/images/menu-icon5.svg') }}" alt="">
                            Family Notes & Feedback
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('document.requests.all') }}" class="nav-item nav-link">
                            <img src="{{ asset('caregiver/assets/images/menu-icon6.svg') }}" alt="">
                            Document Vault
                        </a>
                    </li>

                    <li>
                        <a href=" " class="nav-item nav-link">
                            <img src="{{ asset('caregiver/assets/images/menu-icon7.svg') }}" alt="">
                            Transportation Details
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('familyMember.bills.index') }}" class="nav-item nav-link">
                            <img src="{{ asset('family_owner/assets/images/menu-icon4.svg') }}" alt="">
                            Billing Vault
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('familyMember.contribution.index') }}" class="nav-item nav-link">
                            <img src="{{ asset('family_owner/assets/images/menu-icon5.svg') }}" alt="">
                            Financial Contributions
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('familyMember.reimbursment.index') }}" class="nav-item nav-link">
                            <img src="{{ asset('family_owner/assets/images/menu-icon6.svg') }}" alt="">
                            Reimbursement Requests
                        </a>
                    </li>

                    {{-- <li>
                        <a href="{{ route('caregiver.emergency.index') }}" class="nav-item nav-link">
                            <img src="{{ asset('caregiver/assets/images/menu-icon7.svg') }}" alt="">
                            Emergency Protocol
                        </a>
                    </li> --}}
                </ul>

                <!-- Support Section -->
                {{-- <ul class="navFt">
                    <span class="subNav">Support</span>
                    <li>
                        <a href="{{ route('caregiver.help') }}">
                            <img src="{{ asset('caregiver/assets/images/menu-icon8.svg') }}" alt="">
                            Help Center
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('caregiver.settings') }}">
                            <img src="{{ asset('caregiver/assets/images/menu-icon9.svg') }}" alt="">
                            Settings
                        </a>
                    </li>
                </ul> --}}

            </div>
        </nav>
    </div>
</div>
