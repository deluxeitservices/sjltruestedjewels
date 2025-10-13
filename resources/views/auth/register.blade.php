@extends('layouts.app')
@section('title', 'SJL')
@section('content')

    <main>
        <div class="register-page">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h2 class="common-title">Create an account</h2>
                        <p>Register today! Start building points and get access to
                            exclusive discounts.</p>
                    </div>

                </div>
                <div class="row register-row">
                    <div class="col-md-5 col-12">
                        <div class="register-img"></div>
                    </div>
                    <div class="col-md-7 col-12">
                        <div class="col-md-12">
                            <div class="register-info">
                                <span><i class="fa-solid fa-circle-info"></i></span>
                                <p> Please note we have to conduct identity and security
                                    checks in order to ensure safe
                                    delivery of your items.</p>
                            </div>
                        </div>
                        @error('email')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                        <form method="POST" action="{{ route('register') }}" class="needs-validation register-form"
                            novalidate>
                            @csrf
                            <div class="row g-3">
                                <!-- <div class="col-md-6 position-relative">
                    <div class="form-outline" data-mdb-input-init>
                      <input type="text" class="form-control"
                        id="validationTooltip00" value="Mark" required />
                      <label for="validationTooltip00" class="form-label">First
                        name</label>

                      <div class="invalid-tooltip">First Name is required</div>
                    </div>
                    <div class="common-user">
                      <i class="fa-solid fa-user"></i>
                    </div>
                  </div>
                  <div class="col-md-6 position-relative">
                    <div class="form-outline" data-mdb-input-init>
                      <input type="text" class="form-control"
                        id="validationTooltip01" value="{{ old('name') }}"> required />
                      <label for="validationTooltip01" class="form-label">Last
                        name</label>
                      <div class="invalid-tooltip">Last Name is required

                      </div>
                    </div>
                    <div class="common-user">
                      <i class="fa-solid fa-user"></i>
                    </div>
                  </div> -->
                                <div class="col-md-12 position-relative">
                                    <div class="form-outline" data-mdb-input-init>
                                        <input type="text" name="name" class="form-control" id="validationTooltip00"
                                            value="{{ old('name') }}" required />
                                        <label for="validationTooltip00" class="form-label">
                                            Name</label>
                                        <div class="invalid-tooltip">Name is required</div>
                                    </div>
                                    <div class="common-user">
                                        <i class="fa-solid fa-user"></i>
                                    </div>
                                </div>
                                <div class="col-md-6 position-relative">
                                    <div class="form-outline" data-mdb-input-init>

                                        <input type="date" name="dob" class="form-control date-input"
                                            id="validationTooltip02" value="{{ old('dob') }}" required />
                                        <label for="validationTooltip02" class="form-label">Date
                                            of Birth</label>
                                        <div class="invalid-tooltip">Please enter DD-MM-YYYY
                                            format (e.g.26-02-1990)</div>
                                    </div>
                                    <div class="common-user">
                                        <i class="fa-solid fa-calendar-days"></i>
                                    </div>
                                </div>
                                <div class="col-md-6 position-relative">
                                    <div class="form-outline" data-mdb-input-init>
                                        <input type="text" name="mobile" class="form-control" id="validationTooltip03"
                                            value="{{ old('mobile') }}" required />
                                        <label for="validationTooltip03" class="form-label">Mobile
                                            Number</label>
                                        <div class="invalid-tooltip">Mobile Number is
                                            required</div>
                                    </div>
                                    <div class="common-user">
                                        <i class="fa-solid fa-phone"></i>
                                    </div>
                                </div>
                                <div class="col-md-12 position-relative">
                                    <div class="form-outline" data-mdb-input-init>
                                        <input type="email" name="email" class="form-control" id="validationTooltip04"
                                            value="{{ old('email') }}" required />
                                        <label for="validationTooltip04" class="form-label">Email</label>
                                        <div class="invalid-tooltip">Email is required</div>
                                    </div>
                                    <div class="common-user">
                                        <i class="fa-regular fa-envelope"></i>
                                    </div>

                                </div>
                                <div class="col-md-6 position-relative">
                                    <div class="form-outline" data-mdb-input-init>
                                        <input type="password" name="password" class="form-control" id="password"
                                            value="{{ old('password') }}" required />
                                        <label for="password" class="form-label">Password</label>
                                        <div class="invalid-tooltip">Password is required</div>
                                    </div>
                                    <div class="input-icon">
                                        <i class="fa-regular fa-eye toggle-password"></i>
                                    </div>
                                </div>

                                <div class="col-md-6 position-relative">
                                    <div class="form-outline" data-mdb-input-init>
                                        <input type="password" name="confirm_password" class="form-control"
                                            id="confirm_password" value="{{ old('confirm_password') }}" required />
                                        <label for="confirm_password" class="form-label">Confirm Password</label>
                                        <div class="invalid-tooltip">Confirm Password is required</div>
                                    </div>
                                    <div class="input-icon"
                                  >
                                        <i class="fa-regular fa-eye toggle-password"></i>
                                    </div>
                                </div>

                                <div class="col-md-6 position-relative">
                                    <div class="form-outline" data-mdb-input-init>

                                        <input type="text" name="address" class="form-control"
                                            id="validationTooltip07" value="{{ old('name') }}" required />
                                        <label for="validationTooltip07" class="form-label">
                                            Address</label>
                                        <div class="invalid-tooltip">Find Address is
                                            required</div>
                                    </div>
                                    <div class="common-user">
                                        <i class="fa-solid fa-location-dot"></i>
                                    </div>
                                </div>
                                <div class="col-md-6 position-relative">
                                    <div class="form-outline" data-mdb-input-init>

                                        <input type="text" name="house_no" class="form-control"
                                            id="validationTooltip08" value="{{ old('house_no') }}" required />
                                        <label for="validationTooltip08" class="form-label">House
                                            No. / Name</label>
                                        <div class="invalid-tooltip">House Number is
                                            required</div>
                                    </div>
                                    <div class="common-user">
                                        <i class="fa-solid fa-location-dot"></i>
                                    </div>
                                </div>
                                <div class="col-md-6 position-relative">
                                    <div class="form-outline" data-mdb-input-init>
                                        <input type="text" name="street_name" class="form-control"
                                            id="validationTooltip10" value="{{ old('street_name') }}" required />
                                        <label for="validationTooltip10" class="form-label">Street
                                            Name*</label>
                                        <div class="invalid-tooltip">Street name is required</div>
                                    </div>
                                    <div class="common-user">
                                        <i class="fa-solid fa-location-dot"></i>
                                    </div>
                                </div>
                                <div class="col-md-6 position-relative">
                                    <div class="form-outline" data-mdb-input-init>

                                        <input type="text" name="city" class="form-control"
                                            id="validationTooltip12" value="{{ old('city') }}" required />
                                        <label for="validationTooltip12" class="form-label">City*</label>
                                        <div class="invalid-tooltip">City is required</div>
                                    </div>
                                    <div class="common-user">
                                        <i class="fa-solid fa-city"></i>
                                    </div>
                                </div>
                                <div class="col-md-6 position-relative">
                                    <div class="form-outline" data-mdb-input-init>

                                        <input type="text" name="postal_code" class="form-control"
                                            id="validationTooltip13" value="{{ old('postal_code') }}" required />
                                        <label for="validationTooltip13" class="form-label">Postal/Zip
                                            Code*</label>
                                        <div class="invalid-tooltip">Street name is required</div>
                                    </div>
                                    <div class="common-user map-icon">
                                        <i class="fa-solid fa-map-pin"></i>
                                    </div>
                                </div>
                                <div class="col-md-6 position-relative">
                                    <div class="form-outline" data-mdb-input-init>

                                        <input type="text" name="country" class="form-control"
                                            id="validationTooltip14" value="{{ old('country') }}" required />
                                        <label for="validationTooltip14" class="form-label">Country*</label>
                                        <div class="invalid-tooltip">Country is required</div>
                                    </div>
                                    <div class="common-user">
                                        <i class="fa-solid fa-earth-americas"></i>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value id="invalidCheck"
                                            required />
                                        <label class="form-check-label" for="invalidCheck">I agree
                                            to the
                                            <a href="#" target="_blank">Terms of service </a>
                                            and
                                            <a href="#" target="_blank">Privacy policy</a>
                                        </label>
                                        <!-- <div class="invalid-feedback">You must agree before submitting.</div> -->

                                    </div>
                                </div>
                                <div class="col-12">
                                    <a href="#"><button class="btn common-primary-btn" type="submit"
                                            data-mdb-ripple-init><i class="fa-solid fa-user-plus"></i> Create
                                            Account</button></a>
                                    <p class="password-link login-link">Already have an account? <a class="p-link"
                                            href="{{ route('login') }}">Login</a>
                                    </p>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- <div class="row">
            <div class="col-12" id="last-row">
              <div class="text-center register-link">
                <p class="password-link login-link">Already have an account? <a
                    class="p-link" href="{{ route('login') }}">Login</a>
                </p>
              </div>
            </div>
          </div> -->
            </div>
        </div>
    </main>
    <script>
    // Select all toggle icons
    const toggleIcons = document.querySelectorAll('.toggle-password');

    toggleIcons.forEach(icon => {
        icon.addEventListener('click', function () {
            // Find the associated input
            const input = this.closest('.position-relative').querySelector('input');

            // Toggle input type
            const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
            input.setAttribute('type', type);

            // Toggle eye icon classes
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });
    });
</script>
@endsection
