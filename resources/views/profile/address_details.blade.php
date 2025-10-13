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
                                <form id="user-address-form" class="needs-validation register-form"
                                    novalidate>
                                    <div class="row g-3">
                                        <?php //dd($addresses); 
                                        ?>

                                        <div class="col-md-6 position-relative">
                                            <div class="form-outline" data-mdb-input-init>

                                                <input type="text" class="form-control"
                                                    id="address" value="{{$addresses->address}}" required />
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
                                                    id="house_no" value="{{$addresses->house_no}}" required />
                                                <label for="house_no"
                                                    class="form-label">House No./Name</label>
                                                <div class="invalid-tooltip">House No./Name is
                                                    required</div>
                                            </div>
                                            <div class="common-user">
                                                <i class="fa-solid fa-location-dot"></i>
                                            </div>
                                        </div>
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
                                        <div class="col-md-6 position-relative">
                                            <div class="form-outline" data-mdb-input-init>

                                                <input type="text" class="form-control"
                                                    id="city" value="{{$addresses->city}}" required />
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
                                                    id="street_name" value="{{$addresses->street_name}}" required />
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
                                                    id="postal_code" value="{{$addresses->postal_code}}" required />
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
                                                    id="country" value="{{$addresses->country}}" required />
                                                <label for="country"
                                                    class="form-label">Country*</label>
                                                <div class="invalid-tooltip">Country is
                                                    required</div>
                                            </div>
                                            <div class="common-user">
                                                <i class="fa-solid fa-earth-americas"></i>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-check">

                                                <input class="form-check-input" type="checkbox" value="{{$addresses->default_address}}"
                                                    id="is_default" {{$addresses->default_address ? 'checked disabled' : ''}}  />
                                                
                                                <label class="form-check-label" for="invalidCheck">Is Default?
                                                </label>
                                                <!-- <div class="invalid-feedback">You must agree before submitting.</div> -->

                                            </div>
                                        </div>


                                        <div class="col-12">
                                            <div class="save-btn-account">
                                                <!-- <a href="register.html"><button
                                                        class="btn common-primary-btn" type="submit"
                                                        data-mdb-ripple-init>Save</button></a> -->
                                                <input type="hidden" 
                                                id="address_id" value="{{$addresses->id}}" />
                                                <div id="ajax-message" class="alert d-none mt-3"></div>
                                                <button type="button" class="common-primary-btn" id="user-address-button" class="pr-btn2 button w-100 mt-3">Save Changes</button>
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
    var updateAddressUrl = @json(route('update.address'));
    var csrfToken = @json(csrf_token());
</script>
@endsection