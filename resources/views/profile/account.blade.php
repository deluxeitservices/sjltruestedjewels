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
                    <div id="account" class="content-section">
                        <div class="card account-form">
                            <div class="card-body">
                                <form id="user-account-form" class="needs-validation register-form"
                                    novalidate>
                                    <div class="row g-3">
                                        <div
                                            class="col-md-12 position-relative choose-file-input">
                                            <label class="form-label" for="profile_picture">Profile
                                                Picture</label>
                                            <input type="file" name="profile_picture" class="form-control"
                                                id="profile_picture" />
                                        </div>
                                        <div class="col-md-6 position-relative">
                                            <div class="form-outline" data-mdb-input-init>
                                                <input type="text" class="form-control"
                                                    id="name" value="{{$userData->name}}" required />
                                                <label for="name"
                                                    class="form-label">Name</label>

                                                <div class="invalid-tooltip">Name is
                                                    required</div>
                                            </div>
                                            <div class="common-user">
                                                <i class="fa-solid fa-user"></i>
                                            </div>
                                        </div>
                                        <!-- <div class="col-md-6 position-relative">
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
                                        </div> -->
                                        <div class="col-md-6 position-relative">
                                            <div class="form-outline" data-mdb-input-init>
                                                <input type="text" class="form-control"
                                                    id="email" value="{{$userData->email}}" readonly required />
                                                <label for="email"
                                                    class="form-label">Email</label>
                                                <div class="invalid-tooltip">Email is
                                                    required</div>
                                            </div>
                                            <div class="common-user">
                                                <i class="fa-regular fa-envelope"></i>
                                            </div>
                                        </div>
                                        <!-- <div class="col-md-6 position-relative">
                                            <div class="form-outline" data-mdb-input-init>

                                                <input type="text" class="form-control"
                                                    id="address" value="{{$userData->address}}" required />
                                                <label for="address"
                                                    class="form-label">Address</label>
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
                                                    id="house_no" value="{{$userData->house_no}}" required />
                                                <label for="house_no"
                                                    class="form-label">House No./Name</label>
                                                <div class="invalid-tooltip">House No./Name is
                                                    required</div>
                                            </div>
                                            <div class="common-user">
                                                <i class="fa-solid fa-location-dot"></i>
                                            </div>
                                        </div> -->
                                        <!-- <div class="col-md-6 position-relative">
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
                                        </div> -->
                                        <!-- <div class="col-md-6 position-relative">
                                            <div class="form-outline" data-mdb-input-init>

                                                <input type="text" class="form-control"
                                                    id="city" value="{{$userData->city}}" required />
                                                <label for="city"
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
                                                    id="street_name" value="{{$userData->street_name}}" required />
                                                <label for="street_name"
                                                    class="form-label">Street Name*</label>
                                                <div class="invalid-tooltip">Street Name is
                                                    required</div>
                                            </div>
                                            <div class="common-user">
                                                <i class="fa-solid fa-earth-americas"></i>
                                            </div>
                                        </div>
                                        <div class="col-md-6 position-relative">
                                            <div class="form-outline" data-mdb-input-init>

                                                <input type="text" class="form-control"
                                                    id="postal_code" value="{{$userData->postal_code}}" required />
                                                <label for="postal_code"
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
                                                    id="country" value="{{$userData->country}}" required />
                                                <label for="country"
                                                    class="form-label">Country*</label>
                                                <div class="invalid-tooltip">Country is
                                                    required</div>
                                            </div>
                                            <div class="common-user">
                                                <i class="fa-solid fa-earth-americas"></i>
                                            </div>
                                        </div> -->
                                        <div class="col-md-6 position-relative">
                                            <div class="form-outline" data-mdb-input-init>
                                                <input type="text" class="form-control"
                                                    id="mobile" value="{{$userData->mobile}}" required />
                                                <label for="mobile"
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
                                                <!-- <a href="register.html"><button
                                                        class="btn common-primary-btn" type="submit"
                                                        data-mdb-ripple-init>Save</button></a> -->
                                                <div id="ajax-message" class="alert d-none mt-3"></div>
                                                <button type="button" class="common-primary-btn" id="user-account-button" class="pr-btn2 button w-100 mt-3">Save Changes</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<script>
    var updateAccountUrl = @json(route('update.account')); 
    var csrfToken = @json(csrf_token()); 
</script>
@endsection
