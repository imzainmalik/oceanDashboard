<div class="sidebar-wrapper scrollbar scrollbar-inner">
    <div class="sidebar">
        <nav>
            <a href="index.php" class="logo text-dark w-100">
                <img src="{{ asset('family_owner/assets/images/logo01.png') }}" alt="">
            </a>

            <div class="navBottom">

                <div class="search">
                    <button><i class="fal fa-search"></i></button>
                    <input type="text" placeholder="Search">
                </div>

                <ul class="navbar-nav w-100">
                    <span class="subNav">General</span>
                    <li>
                        <a href="{{ route('familyOwner.index') }}" class="nav-item nav-link">
                            <img src="{{ asset('family_owner/assets/images/menu-icon1.svg') }}" alt=""> Overview
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('familyOwner.logs') }}" class="nav-item nav-link"><img
                                src="{{ asset('family_owner/assets/images/menu-icon2.svg') }}" alt="">Activity Timeline</a>
                    </li>

                    <li>
                        <a href="{{ route('familyOwner.tasks.index') }}" class="menu-item nav-item nav-link">
                            <img src="{{ asset('family_owner/assets/images/menu-icon3.svg') }}" alt=""> 
                            Request & Response
                        </a> 
                    </li>

                    <li>
                        <a href="javascript:;" class="nav-item nav-link"><img src="{{ asset('family_owner/assets/images/menu-icon4.svg') }}"
                                alt="">
                            Assigned Roles Tracker</a>
                    </li>

                   <li> <a href="javascript:;" class="nav-item nav-link"><img src="{{ asset('family_owner/assets/images/menu-icon5.svg') }}" alt="">
                        Family Notes & Feedback </a></li>

                    <li>
                        <a href="document-vault.php" class="nav-item nav-link"><img src="{{ asset('family_owner/assets/images/menu-icon6.svg') }}" alt="">
                            Document Vault </a>
                    </li>

                    <li>
                        <a href="emergency-protocol.php" class="nav-item nav-link"><img src="{{ asset('family_owner/assets/images/menu-icon7.svg') }}" alt="">
                            Emergency Protocol </a>
                    </li>
                </ul>

                {{-- <ul class="navFt">
                    <span class="subNav">Support</span>
                    <li>
                        <a href="javascript:;"><img src="{{ asset('family_owner/assets/images/logo01.png') }}" alt=""> Help Center</a>
                    </li>
                    <li>
                        <a href="javascript:;"><img src="{{ asset('family_owner/assets/images/logo01.png') }}" alt=""> Settings</a>
                    </li>
                </ul> --}}
            </div>

        </nav>
    </div>
</div>