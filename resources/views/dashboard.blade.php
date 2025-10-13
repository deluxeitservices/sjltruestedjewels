@extends('layouts.app')
@section('title', 'SJL')
@section('content')
<main class="profile-page">
    <div class="container py-5">
        <div class="row">
            <!-- Sidebar -->
            @include('profile.profilecommon')
            <!-- Content Area -->
            <div class="col-lg-9 col-md-12">
                <div class="pofile-content-card">
                    <div id="dashboard" class="content-section">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-4">
                                    <a href="order">
                                        <div class="card border-0">
                                            <div
                                                class="card-body d-flex align-items-center flex-column">
                                                <i class="fa-solid fa-bag-shopping"></i>
                                                <p class=" pt-3">Orders</p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-md-4">
                                    <a href="account">
                                        <div class="card border-0">
                                            <div
                                                class="card-body d-flex align-items-center flex-column">
                                                <i class="fa-solid fa-user"></i>
                                                <p class=" pt-3">Account</p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-md-4">
                                    <a href="wishlist">
                                        <div class="card border-0">
                                            <div
                                                class="card-body d-flex align-items-center flex-column">
                                                <i class="fa-solid fa-heart"></i>
                                                <p class=" pt-3">Wishlist</p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="orders" class="content-section d-none">
                        <table
                            id="order-list-table"
                            class="display order-list-table table table-striped table-hover table-bordered align-middle table-responsive nowrap">
                            <thead class="table-light">
                                <tr>
                                    <th>Order</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Total</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>#OD9189174523</td>
                                    <td>2023-05-14</td>
                                    <td>Cancelled</td>
                                    <td>7,214.83</td>
                                    <td class="primary-view">
                                        <a href="#" class="common-primary-btn"><i
                                                class="fa-solid fa-eye"></i>
                                        </a>
                                        <a href="#" class="common-primary-btn">
                                            <i class="fa-solid fa-cloud-arrow-down"></i>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>#OD9189174525</td>
                                    <td>2024-02-12</td>
                                    <td>Pending</td>
                                    <td>2,714.83</td>
                                    <td class="primary-view">
                                        <a href="#" class="common-primary-btn"><i
                                                class="fa-solid fa-eye"></i>
                                        </a>
                                        <a href="#" class="common-primary-btn">
                                            <i class="fa-solid fa-cloud-arrow-down"></i>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>#OD9189174522</td>
                                    <td>2025-02-1</td>
                                    <td>Completed</td>
                                    <td>8,714.83</td>
                                    <td class="primary-view">
                                        <a href="#" class="common-primary-btn"><i
                                                class="fa-solid fa-eye"></i>
                                        </a>
                                        <a href="#" class="common-primary-btn">
                                            <i class="fa-solid fa-cloud-arrow-down"></i>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>#OD9189174526</td>
                                    <td>2025-06-1</td>
                                    <td>Completed</td>
                                    <td>7,714.83</td>
                                    <td class="primary-view">
                                        <a href="#" class="common-primary-btn"><i
                                                class="fa-solid fa-eye"></i>
                                        </a>
                                        <a href="#" class="common-primary-btn">
                                            <i class="fa-solid fa-cloud-arrow-down"></i>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>#OD9189174525</td>
                                    <td>2024-02-12</td>
                                    <td>Pending</td>
                                    <td>2,714.83</td>
                                    <td class="primary-view">
                                        <a href="#" class="common-primary-btn"><i
                                                class="fa-solid fa-eye"></i>
                                        </a>
                                        <a href="#" class="common-primary-btn">
                                            <i class="fa-solid fa-cloud-arrow-down"></i>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>#OD9189174522</td>
                                    <td>2025-02-1</td>
                                    <td>Completed</td>
                                    <td>8,714.83</td>
                                    <td class="primary-view">
                                        <a href="#" class="common-primary-btn"><i
                                                class="fa-solid fa-eye"></i>
                                        </a>
                                        <a href="#" class="common-primary-btn">
                                            <i class="fa-solid fa-cloud-arrow-down"></i>
                                        </a>
                                    </td>
                                </tr>

                            </tbody>

                        </table>
                        <div class="order-detail-section">
                            <div class="conttainer">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h6>Order Details</h6>
                                        <div class="detail-box">
                                            <h6>Product</h6>
                                            <h6>Total</h6>
                                        </div>
                                        <div class="sub-detail-box">
                                            <div class="order-image-box">
                                                <span class="category-detail-name">ring</span>
                                                <img src="./assets/image/gold-dimond.png">
                                            </div>
                                            <div class="order-detail-price">
                                                <span class="product-detail-price">
                                                    £450.00
                                                </span>
                                            </div>
                                        </div>
                                        <div class="order-shpping-text">
                                            <span>Shipping</span>
                                            <span>Free Shipping</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="account" class="content-section d-none">
                        <div class="card account-form">
                            <div class="card-body">
                                <form class="needs-validation register-form"
                                    novalidate>
                                    <div class="row g-3">
                                        <div
                                            class="col-md-12 position-relative choose-file-input">
                                            <label class="form-label" for="customFile">Profile
                                                Picture</label>
                                            <input type="file" class="form-control"
                                                id="customFile" />
                                        </div>
                                        <div class="col-md-6 position-relative">
                                            <div class="form-outline" data-mdb-input-init>
                                                <input type="text" class="form-control"
                                                    id="validationTooltip00" value required />
                                                <label for="validationTooltip00"
                                                    class="form-label">First name</label>

                                                <div class="invalid-tooltip">First Name is
                                                    required</div>
                                            </div>
                                            <div class="common-user">
                                                <i class="fa-solid fa-user"></i>
                                            </div>
                                        </div>
                                        <div class="col-md-6 position-relative">
                                            <div class="form-outline" data-mdb-input-init>
                                                <input type="text" class="form-control"
                                                    id="validationTooltip01" value required />
                                                <label for="validationTooltip01"
                                                    class="form-label">Last name</label>
                                                <div class="invalid-tooltip">Last Name is required

                                                </div>
                                            </div>
                                            <div class="common-user">
                                                <i class="fa-solid fa-user"></i>
                                            </div>
                                        </div>
                                        <div class="col-md-12 position-relative">
                                            <div class="form-outline" data-mdb-input-init>
                                                <input type="text" class="form-control"
                                                    id="validationTooltip04" value required />
                                                <label for="validationTooltip04"
                                                    class="form-label">Email</label>
                                                <div class="invalid-tooltip">Email is
                                                    required</div>
                                            </div>
                                            <div class="common-user">
                                                <i class="fa-regular fa-envelope"></i>
                                            </div>
                                        </div>
                                        <div class="col-md-6 position-relative">
                                            <div class="form-outline" data-mdb-input-init>

                                                <input type="text" class="form-control"
                                                    id="validationTooltip02" value required />
                                                <label for="validationTooltip07"
                                                    class="form-label">Address line 1</label>
                                                <div class="invalid-tooltip">Address is
                                                    required</div>
                                            </div>
                                            <div class="common-user">
                                                <i class="fa-solid fa-location-dot"></i>
                                            </div>
                                        </div>
                                        <div class="col-md-6 position-relative">
                                            <div class="form-outline" data-mdb-input-init>

                                                <input type="text" class="form-control"
                                                    id="validationTooltip03" value required />
                                                <label for="validationTooltip07"
                                                    class="form-label">Address line 2</label>
                                                <div class="invalid-tooltip">Address is
                                                    required</div>
                                            </div>
                                            <div class="common-user">
                                                <i class="fa-solid fa-location-dot"></i>
                                            </div>
                                        </div>
                                        <div class="col-md-12 position-relative">
                                            <div class="form-outline" data-mdb-input-init>

                                                <input type="text" class="form-control"
                                                    id="validationTooltip4" value required />
                                                <label for="validationTooltip4"
                                                    class="form-label">City*</label>
                                                <div class="invalid-tooltip">City is
                                                    required</div>
                                            </div>
                                            <div class="common-user">
                                                <i class="fa-solid fa-city"></i>
                                            </div>
                                        </div>
                                        <div class="col-md-6 position-relative">
                                            <div class="form-outline" data-mdb-input-init>

                                                <input type="text" class="form-control"
                                                    id="validationTooltip14" value required />
                                                <label for="validationTooltip5"
                                                    class="form-label">State*</label>
                                                <div class="invalid-tooltip">State is
                                                    required</div>
                                            </div>
                                            <div class="common-user">
                                                <i class="fa-solid fa-earth-americas"></i>
                                            </div>
                                        </div>
                                        <div class="col-md-6 position-relative">
                                            <div class="form-outline" data-mdb-input-init>

                                                <input type="text" class="form-control"
                                                    id="validationTooltip13" value required />
                                                <label for="validationTooltip13"
                                                    class="form-label">Postal/Zip
                                                    Code*</label>
                                                <div class="invalid-tooltip">Street name is
                                                    required</div>
                                            </div>
                                            <div class="common-user map-icon">
                                                <i class="fa-solid fa-map-pin"></i>
                                            </div>
                                        </div>
                                        <div class="col-md-6 position-relative">
                                            <div class="form-outline" data-mdb-input-init>

                                                <input type="text" class="form-control"
                                                    id="validationTooltip14" value required />
                                                <label for="validationTooltip14"
                                                    class="form-label">Country*</label>
                                                <div class="invalid-tooltip">Country is
                                                    required</div>
                                            </div>
                                            <div class="common-user">
                                                <i class="fa-solid fa-earth-americas"></i>
                                            </div>
                                        </div>
                                        <div class="col-md-6 position-relative">
                                            <div class="form-outline" data-mdb-input-init>
                                                <input type="text" class="form-control"
                                                    id="validationTooltip05" value required />
                                                <label for="validationTooltip03"
                                                    class="form-label">Mobile Number</label>
                                                <div class="invalid-tooltip">Mobile Number is
                                                    required</div>
                                            </div>
                                            <div class="common-user">
                                                <i class="fa-solid fa-phone"></i>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="save-btn-account">
                                                <a href="register.html"><button
                                                        class="btn common-primary-btn" type="submit"
                                                        data-mdb-ripple-init>Save</button></a>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div id="wishlist" class="content-section d-none">
                        <table id="wishlist-table"
                            class="display order-list-table table table-striped table-hover table-bordered align-middle table-responsive nowrap">
                            <thead class="table-light">
                                <tr>
                                    <th>Order</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Total</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>#OD9189174523</td>
                                    <td>2023-05-14</td>
                                    <td>Cancelled</td>
                                    <td>7,214.83</td>
                                    <td class="primary-view">
                                        <a href="#" class="common-primary-btn"><i
                                                class="fa-solid fa-eye"></i></a>
                                        <a href="#" class="common-primary-btn"><i
                                                class="fa-solid fa-xmark"></i></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>#OD9189174525</td>
                                    <td>2024-02-12</td>
                                    <td>Pending</td>
                                    <td>2,714.83</td>
                                    <td class="primary-view">
                                        <a href="#" class="common-primary-btn"><i
                                                class="fa-solid fa-eye"></i></a>
                                        <a href="#" class="common-primary-btn"><i
                                                class="fa-solid fa-xmark"></i></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>#OD9189174522</td>
                                    <td>2025-02-1</td>
                                    <td>Completed</td>
                                    <td>8,714.83</td>
                                    <td class="primary-view">
                                        <a href="#" class="common-primary-btn"><i
                                                class="fa-solid fa-eye"></i></a>
                                        <a href="#" class="common-primary-btn"><i
                                                class="fa-solid fa-xmark"></i></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>#OD9189174526</td>
                                    <td>2025-06-1</td>
                                    <td>Completed</td>
                                    <td>7,714.83</td>
                                    <td class="primary-view">
                                        <a href="#" class="common-primary-btn"><i
                                                class="fa-solid fa-eye"></i></a>
                                        <a href="#" class="common-primary-btn"><i
                                                class="fa-solid fa-xmark"></i></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>#OD9189174525</td>
                                    <td>2024-02-12</td>
                                    <td>Pending</td>
                                    <td>2,714.83</td>
                                    <td class="primary-view">
                                        <a href="#" class="common-primary-btn"><i
                                                class="fa-solid fa-eye"></i></a>
                                        <a href="#" class="common-primary-btn"><i
                                                class="fa-solid fa-xmark"></i></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>#OD9189174522</td>
                                    <td>2025-02-1</td>
                                    <td>Completed</td>
                                    <td>8,714.83</td>
                                    <td class="primary-view">
                                        <a href="#" class="common-primary-btn"><i
                                                class="fa-solid fa-eye"></i></a>
                                        <a href="#" class="common-primary-btn"><i
                                                class="fa-solid fa-xmark"></i></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>#OD9189174526</td>
                                    <td>2025-06-1</td>
                                    <td>Completed</td>
                                    <td>7,714.83</td>
                                    <td class="primary-view">
                                        <a href="#" class="common-primary-btn"><i
                                                class="fa-solid fa-eye"></i></a>
                                        <a href="#" class="common-primary-btn"><i
                                                class="fa-solid fa-xmark"></i></a>
                                    </td>
                                </tr>

                            </tbody>

                        </table>
                    </div>

                    <div id="logout" class="content-section d-none">
                        <h4>Logout</h4>
                        <p>You have been logged out successfully.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection