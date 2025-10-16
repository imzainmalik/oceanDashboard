<div class="sidebar-wrapper scrollbar scrollbar-inner">
    <div class="sidebar">
        <nav>
            <!-- Logo -->
            <a href="{{ route('senior.index') }}" class="logo text-dark w-100">
                <img src="{{ asset('senior/assets/images/logo01.png') }}" alt="Logo">
            </a>

            <div class="navBottom">
                <!-- Search (optional for seniors) -->
                <div class="search">
                    <button><i class="fal fa-search"></i></button>
                    <input type="text" placeholder="Search">
                </div>

                <ul class="navbar-nav w-100">
                    
                    <span class="subNav">My Dashboard</span>

                    <li>
                        <a href="{{ route('senior.index') }}" class="nav-item nav-link">
                            <img src="{{ asset('senior/assets/images/menu-icon1.svg') }}" alt="">
                            Overview
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('senior.daily-updates.index') }}" class="nav-item nav-link">
                            <img src="{{ asset('senior/assets/images/menu-icon2.svg') }}" alt="">
                            Daily Updates
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('senior.voice-journal.index') }}" class="nav-item nav-link">
                            <img src="{{ asset('senior/assets/images/menu-icon3.svg') }}" alt="">
                            Voice Journal
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('senior.meetings.index') }}" class="nav-item nav-link">
                            <img src="{{ asset('senior/assets/images/menu-icon4.svg') }}" alt="">
                            Meeting Requests
                        </a>
                    </li>

                    <span class="subNav">Vault</span>

                    <li>
                        <a href="{{ route('document.requests.all') }}" class="nav-item nav-link">
                            <img src="{{ asset('senior/assets/images/menu-icon5.svg') }}" alt="">
                            My Documents
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('senior.bills.index') }}" class="nav-item nav-link">
                            <img src="{{ asset('senior/assets/images/menu-icon6.svg') }}" alt="">
                            My Bills
                        </a>
                    </li>

                    <span class="subNav">Settings</span>

                    <li>
                        <a href="{{ route('senior.index') }}" class="nav-item nav-link">
                            <img src="{{ asset('senior/assets/images/menu-icon7.svg') }}" alt="">
                            Notifications
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('senior.index') }}" class="nav-item nav-link">
                            <img src="{{ asset('senior/assets/images/menu-icon8.svg') }}" alt="">
                            Profile Settings
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</div>
