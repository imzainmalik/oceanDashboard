<div class="sidebar-wrapper scrollbar scrollbar-inner">
    <div class="sidebar">
        <nav>
            <!-- Logo -->
            <a href="{{ route(auth()->user()->custom_role . '.index') }}" class="logo text-dark w-100">
                <img src="{{ asset('family_owner/assets/images/logo01.png') }}" alt="Logo">
            </a>

            <div class="navBottom">
                <!-- Search -->
                <div class="search">
                    <button><i class="fal fa-search"></i></button>
                    <input type="text" placeholder="Search">
                </div>

                <ul class="navbar-nav w-100">

                    <span class="subNav">My Dashboard</span>

                    {{-- Dashboard --}}
                    <li>
                        <a href="{{ route(auth()->user()->custom_role . '.index') }}" class="nav-item nav-link">
                            <img src="{{ asset('family_owner/assets/images/menu-icon1.svg') }}" alt="">
                            Overview
                        </a>
                    </li>

                    {{-- Family Members --}}
                    @if(auth()->user()->hasPermission('members_show'))
                        <li>
                            <a href="{{ route(auth()->user()->custom_role . '.all_members') }}" class="nav-item nav-link">
                                <img src="{{ asset('family_owner/assets/images/menu-icon1.svg') }}" alt="">
                                Family Members
                            </a>
                        </li>
                    @endif

                    {{-- Caregivers --}}
                    @if(auth()->user()->hasPermission('caregivers_show'))
                        <li>
                            <a href="{{ route(auth()->user()->custom_role . '.all_members') }}" class="nav-item nav-link">
                                <img src="{{ asset('family_owner/assets/images/menu-icon2.svg') }}" alt="">
                                Caregivers
                            </a>
                        </li>
                    @endif

                    {{-- Daily Tasks and Care Logs --}}
                    @if(auth()->user()->hasPermission('tasks_show'))
                        <li>
                            <a href="{{ route(auth()->user()->custom_role . '.tasks.index') }}" class="nav-item nav-link">
                                <img src="{{ asset('family_owner/assets/images/menu-icon3.svg') }}" alt="">
                                Daily Tasks
                            </a>
                        </li>
                        <li>
                            <a href="{{ route(auth()->user()->custom_role . '.daily-updates.index') }}" class="nav-item nav-link">
                                <img src="{{ asset('family_owner/assets/images/menu-icon4.svg') }}" alt="">
                                Activity timeline
                            </a>
                        </li>
                    @endif

                    <span class="subNav">Vault</span>

                    {{-- Documents --}}
                    @if(auth()->user()->hasPermission('documents_show'))
                        <li>
                            <a href="{{ route('document.requests.all') }}" class="nav-item nav-link">
                                <img src="{{ asset('family_owner/assets/images/menu-icon5.svg') }}" alt="">
                                Document Vault
                            </a>
                        </li>
                    @endif

                    {{-- Bills --}}
                    @if(auth()->user()->hasPermission('bills_show'))
                        <li>
                            <a href="{{ route(auth()->user()->custom_role . '.bills.index') }}" class="nav-item nav-link">
                                <img src="{{ asset('family_owner/assets/images/menu-icon6.svg') }}" alt="">
                                Billing Vault
                            </a>
                        </li>
                    @endif

                    {{-- Contributions (if mapped under Bills or Finance) --}}
                    <li>
                        <a href="{{ route(auth()->user()->custom_role . '.contribution.index') }}" class="nav-item nav-link">
                            <img src="{{ asset('family_owner/assets/images/menu-icon7.svg') }}" alt="">
                            Financial Contributions
                        </a>
                    </li>

                    {{-- Reimbursements (if mapped under Bills) --}}
                    <li>
                        <a href="{{ route(auth()->user()->custom_role . '.reimbursment.index') }}" class="nav-item nav-link">
                            <img src="{{ asset('family_owner/assets/images/menu-icon8.svg') }}" alt="">
                            Reimbursement Requests
                        </a>
                    </li>

                    {{-- Meetings & Events --}}
                    @if(auth()->user()->hasPermission('meetings_show'))
                        <li>
                            <a href="{{ route(auth()->user()->custom_role . '.events.index') }}" class="nav-item nav-link">
                                <img src="{{ asset('family_owner/assets/images/menu-icon9.svg') }}" alt="">
                                Vacations & Outings
                            </a>
                        </li>
                        <li>
                            <a href="{{ route(auth()->user()->custom_role . '.meetings.index') }}" class="nav-item nav-link">
                                <img src="{{ asset('family_owner/assets/images/menu-icon10.svg') }}" alt="">
                                Meetings
                            </a>
                        </li>
                    @endif

                    {{-- Voting Pools --}}
                    @if(auth()->user()->hasPermission('pools_show'))
                        <li>
                            <a href="{{ route(auth()->user()->custom_role . '.pools.index') }}" class="nav-item nav-link">
                                <img src="{{ asset('family_owner/assets/images/menu-icon11.svg') }}" alt="">
                                Family Voting Tool
                            </a>
                        </li>
                    @endif

                    {{-- Notes & Wellness --}}
                    @if(auth()->user()->hasPermission('notes_show'))
                        <li>
                            <a href="{{ route(auth()->user()->custom_role . '.family-notes.index') }}" class="nav-item nav-link">
                                <img src="{{ asset('family_owner/assets/images/menu-icon12.svg') }}" alt="">
                                Notes & Wellness Check-ins
                            </a>
                        </li>
                    @endif

                    {{-- Reports --}}
                    @if(auth()->user()->hasPermission('reports_show'))
                        <li>
                            <a href="{{ route(auth()->user()->custom_role.'.report.index') }}" class="nav-item nav-link">
                                <img src="{{ asset('family_owner/assets/images/menu-icon13.svg') }}" alt="">
                                Reports
                            </a>
                        </li>
                    @endif

                    {{-- Subscription 
                    @if(auth()->user()->hasPermission('subscription_show'))
                        <li>
                            <a href="{{ route('familyMember.subscriptions.index') }}" class="nav-item nav-link">
                                <img src="{{ asset('family_owner/assets/images/menu-icon14.svg') }}" alt="">
                                Subscription
                            </a>
                        </li>
                    @endif--}}

                    {{-- Seniors (Voice Journal / Special Features) --}}
                    @if(auth()->user()->hasPermission('seniors_show'))
                        <li>
                            <a href="{{ route('senior.voice-journal.index') }}" class="nav-item nav-link">
                                <img src="{{ asset('family_owner/assets/images/menu-icon15.svg') }}" alt="">
                                Voice Journal
                            </a>
                        </li>
                    @endif

                    {{-- Caregiver Special --}}
                    @if(auth()->user()->hasPermission('caregiver_show'))
                        <li>
                            <a href="{{ route(auth()->user()->custom_role . '.caregiver.special') }}" class="nav-item nav-link">
                                <img src="{{ asset('family_owner/assets/images/menu-icon16.svg') }}" alt="">
                                Caregiver Special
                            </a>
                        </li>
                    @endif

                </ul>
            </div>
        </nav>
    </div>
</div>
