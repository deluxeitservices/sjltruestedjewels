<div class="col-lg-3 col-md-12">
    <div class="profile-card text-center">
        <div class="user-profile user-img">
            <!-- <img src="./assets/image/user.jpg" alt="User"> -->
            @php
                $profPic =
                    isset($userData->profile_picture) && $userData->profile_picture != ''
                        ? asset('storage/uploads/userprofile/' . $userData->id . '/' . $userData->profile_picture)
                        : asset('assets/image/account.png');
            @endphp
            <img src="{{ $profPic }}" alt="" class="rounded-circle object-fit-cover" height="60px"
                width="60px">
        </div>

        <h5 class="mb-0">{{ $userData->name }}</h5>
        <a href="{{ url('logout') }}" class="logout-text">Logout</a>
        <hr>
        <div class="sidebar-menu">
            <!-- <button class="active" onclick="showContent('dashboard')">
                            <i class="fa-solid fa-boxes-stacked"></i>
                            Dashboard
                        </button> -->
            <a href="{{ url('/dashboard') }}"
                class="main-box d-flex gap-2 align-items-center p-3 mb-2 text-decoration-none desbor-icon m-0 {{ request()->is('dashboard') ? 'active' : '' }}">
                <!-- <div class="main-box d-flex gap-2 align-items-center p-3 mb-2 " id="dashboard-link"> -->
                <i class="fa-solid fa-boxes-stacked"></i>
                <span>Dashboard</span>
                <!-- </div> -->
            </a>
            <!-- <button onclick="showContent('orders')"><i
                                class="fa-solid fa-bag-shopping"></i> Orders</button> -->
            <a href="{{ url('/order') }}"
                class="main-box d-flex gap-2 align-items-center p-3 mb-2 text-decoration-none desbor-icon m-0 {{ request()->is('order') || request()->is('order/*') ? 'active' : '' }}">
                <!-- <div class="main-box d-flex gap-2 align-items-center p-3 mb-2" id="orders-link"> -->
                <i class="fa-solid fa-bag-shopping"></i>
                <span>Orders</span>
                <!-- </div> -->
            </a>

            <!-- <button onclick="showContent('account')">
                            <i class="fa-solid fa-user"></i> Account
                            details
                        </button> -->
            <a href="{{ url('/account') }}"
                class="main-box d-flex gap-2 align-items-center p-3 mb-2 text-decoration-none desbor-icon m-0 {{ request()->is('account') ? 'active' : '' }}">
                <!-- <div class="main-box d-flex gap-2 align-items-center p-3 mb-2 " id="orders-link"> -->
                <i class="fa-solid fa-bag-shopping"></i>
                <span>Account</span>
                <!-- </div> -->
            </a>
            <a href="{{ url('/address') }}"
                class="main-box d-flex gap-2 align-items-center p-3 mb-2 text-decoration-none desbor-icon m-0 {{ request()->is('address') || request()->is('address/*') ? 'active' : '' }}">
                <i class="fa-solid fa-location"></i>
                <span>Addresses</span>
            </a>
            <!-- <button onclick="showContent('wishlist')"><i
                                class="fa-solid fa-heart"></i> Wishlist</button> -->
            <a href="{{ url('/wishlist') }}"
                class="main-box d-flex gap-2 align-items-center p-3 mb-2 text-decoration-none desbor-icon m-0 {{ request()->is('wishlist') ? 'active' : '' }}">
                <!-- <div class="main-box d-flex gap-2 align-items-center p-3 mb-2" id="wishlist-link"> -->
                <i class="fa-solid fa-heart"></i>
                <span>Wishlist</span>
                <!-- </div> -->
            </a>
            <!-- <button onclick="logoutUser()"><i
                                class="fa-solid fa-arrow-right-from-bracket"></i> Log
                            out</button> -->
            <a href="{{ url('/logout') }}"
                class="main-box d-flex gap-2 align-items-center p-3 mb-2 text-decoration-none desbor-icon m-0">
                <!-- <div class="main-box d-flex gap-2 align-items-center p-3 mb-2" id="logout-link"> -->
                <i class="fa-solid fa-right-from-bracket"></i>
                <span>Log out</span>
                <!-- </div> -->
            </a>
        </div>
    </div>
</div>
