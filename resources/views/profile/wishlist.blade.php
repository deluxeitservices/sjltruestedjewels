@extends('layouts.app')
@section('title', 'SJL')
@section('content')
<main class="profile-page">
    <div class="container py-5">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-lg-3 col-md-12">
                <div class="profile-card text-center">
                    <div class="user-profile">
                        <img src="./assets/image/user.jpg" alt="User">
                    </div>
                    <h5 class="mb-0">dp jadv</h5>
                    <a href="{{url('logout')}}" class="logout-text">Logout</a>
                    <hr>
                    <div class="sidebar-menu">
                        <!-- <button class="active" onclick="showContent('dashboard')">
                            <i class="fa-solid fa-boxes-stacked"></i>
                            Dashboard
                        </button> -->
                        <a href="{{ url('/dashboard') }}" class="main-box d-flex gap-2 align-items-center p-3 mb-2 text-decoration-none desbor-icon m-0">
                            <!-- <div class="main-box d-flex gap-2 align-items-center p-3 mb-2 " id="dashboard-link"> -->
                            <i class="fa-solid fa-boxes-stacked"></i>
                            <span>Dashboard</span>
                            <!-- </div> -->
                        </a>
                        <!-- <button onclick="showContent('orders')"><i
                                class="fa-solid fa-bag-shopping"></i> Orders</button> -->
                        <a href="{{ url('/order') }}" class="main-box d-flex gap-2 align-items-center p-3 mb-2 text-decoration-none desbor-icon m-0 ">
                            <!-- <div class="main-box d-flex gap-2 align-items-center p-3 mb-2" id="orders-link"> -->
                            <i class="fa-solid fa-bag-shopping"></i>
                            <span>Orders</span>
                            <!-- </div> -->
                        </a>

                        <!-- <button onclick="showContent('account')">
                            <i class="fa-solid fa-user"></i> Account
                            details
                        </button> -->
                        <a href="{{ url('/account') }}" class="main-box d-flex gap-2 align-items-center p-3 mb-2 text-decoration-none desbor-icon m-0 ">
                            <!-- <div class="main-box d-flex gap-2 align-items-center p-3 mb-2 " id="orders-link"> -->
                            <i class="fa-solid fa-bag-shopping"></i>
                            <span>Account details</span>
                            <!-- </div> -->
                        </a>
                        <!-- <button onclick="showContent('wishlist')"><i
                                class="fa-solid fa-heart"></i> Wishlist</button> -->
                        <a href="{{ url('/wishlist') }}" class="main-box d-flex gap-2 align-items-center p-3 mb-2 text-decoration-none desbor-icon m-0 active">
                            <!-- <div class="main-box d-flex gap-2 align-items-center p-3 mb-2" id="wishlist-link"> -->
                            <i class="fa-solid fa-heart"></i>
                            <span>Wishlist</span>
                            <!-- </div> -->
                        </a>
                        <!-- <button onclick="logoutUser()"><i
                                class="fa-solid fa-arrow-right-from-bracket"></i> Log
                            out</button> -->
                        <a href="{{ url('/logout') }}" class="main-box d-flex gap-2 align-items-center p-3 mb-2 text-decoration-none desbor-icon m-0">
                            <!-- <div class="main-box d-flex gap-2 align-items-center p-3 mb-2" id="logout-link"> -->
                            <i class="fa-solid fa-right-from-bracket"></i>
                            <span>Log out</span>
                            <!-- </div> -->
                        </a>
                    </div>
                </div>
            </div>

            <!-- Content Area -->
            <div class="col-lg-9 col-md-12">
                <div class="pofile-content-card">
                    <div id="wishlist" class="content-section">
                        <table id="wishlist-table"
                            class="display order-list-table table table-striped table-hover table-bordered align-middle table-responsive nowrap">
                            <thead class="table-light">
                                <tr>
                                    <th>Product</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($favorites)): ?>
                                    <?php foreach ($favorites as $order):

                                    ?>
                                        <tr>
                                            <td>
                                                <img width="50" height="50"
                                                    src="<?= htmlspecialchars($order['image_url']) ?>"
                                                    onclick="zoomImage('<?= htmlspecialchars($order['image_url']) ?>')"
                                                    style="cursor: pointer;">

                                            </td>

                                            <td><?= htmlspecialchars($order['created_at']) ?></td>
                                            <td class="primary-view">
                                                <a class="common-primary-btn"  href="{{ route('ext.product', ['category' => $order['prefix'], 'slug' => $order['slug']]) }}" class="block">
                                                    <i class="fa fa-eye"></i>
                                                </a>    
                                         
                                                <a href="javascript:void(0);" 
                                                class="common-primary-btn unfav-btn" 
                                                data-id="{{ $order->id }}">
                                                    <i class="fa-solid fa-xmark"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="5" class="text-center">No favorite orders found.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>

                    </div>

                </div>
            </div>
        </div>
    </div>
</main>
@endsection
<script>

</script>