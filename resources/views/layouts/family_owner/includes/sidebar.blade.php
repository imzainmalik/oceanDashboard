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
                @php
                    $subscription = check_user_subscribed();
                    // dd($subscription);
                @endphp
                <ul class="navbar-nav w-100">
                    <span class="subNav">General</span>
                    @if ($subscription != null && $subscription->status == 'active')
                        <li>
                            <a href="{{ route('familyOwner.index') }}" class="nav-item nav-link">
                                <img src="{{ asset('family_owner/assets/images/menu-icon1.svg') }}" alt="">
                                Overview
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('familyOwner.all_members') }}"><img
                                    src="{{ asset('family_owner/assets/images/menu-icon1.svg') }}" alt="">
                                Family members</a>
                        </li>
                        <li>
                            <a href="{{ route('familyOwner.logs') }}" class="nav-item nav-link"><img
                                    src="{{ asset('family_owner/assets/images/menu-icon2.svg') }}"
                                    alt="">Activity
                                Timeline</a>
                        </li>

                        <li>
                            <a href="{{ route('familyOwner.tasks.index') }}" class="menu-item nav-item nav-link">
                                <img src="{{ asset('family_owner/assets/images/menu-icon3.svg') }}" alt="">
                                Request & Response
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('familyOwner.subscriptions.index') }}" class="nav-item nav-link"><img
                                    src="{{ asset('family_owner/assets/images/menu-icon4.svg') }}" alt="">
                                Subscription</a>
                        </li>

                        <li> <a href="{{ route('familyOwner.family-notes.index') }}" class="nav-item nav-link"><img
                                    src="{{ asset('family_owner/assets/images/menu-icon5.svg') }}" alt="">
                                Family Notes & Feedback </a></li>

                        <li>
                            <a href="{{ route('document.requests.all') }}" class="nav-item nav-link"><img
                                    src="{{ asset('family_owner/assets/images/menu-icon6.svg') }}" alt="">
                                Document Vault </a>
                        </li>

                        <li>
                            <a href="{{ route('familyOwner.bills.index') }}" class="nav-item nav-link"><img
                                    src="{{ asset('family_owner/assets/images/menu-icon7.svg') }}" alt="">
                                Billing Vault </a>
                        </li>
                        <li>
                            <a href="{{ route('familyOwner.report.index') }}"><img
                                    src="{{ asset('family_owner/assets/images/menu-icon7.svg ') }}"
                                    alt="">Report</a>
                        </li>
                        <li>
                            <a href="{{ route('familyOwner.pools.index') }}"><img
                                    src="{{ asset('family_owner/assets/images/menu-icon7.svg ') }}"
                                    alt="">Voting pool</a>
                        </li>
                    @else
                        <li>
                            <a href="{{ route('subscription.packages') }}"><img
                                    src="{{ asset('family_owner/assets/images/menu-icon7.svg ') }}"
                                    alt="">Subscribe</a>
                        </li>
                    @endif
                </ul>


            </div>

        </nav>
    </div>
</div>
