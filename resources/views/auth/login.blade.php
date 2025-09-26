@extends('layouts.app')
@section('title', 'SJL')
@section('content')
  <main>
    <div class="login-page">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <h2 class="common-title">Login</h2>
            <p>Checkout process will be quicker if you are logged in.</p>
          </div>

        </div>
        <div class="row login-row">
          <div class="col-md-5 col-12">
            <div class="login-img"></div>
          </div>
          <div class="col-md-7 col-12">
            <form method="POST" action="{{ route('login') }}" class="needs-validation login-form" novalidate>
              @csrf
              <div class="row g-3">

                <div class="col-md-10 position-relative">
                  <div class="form-outline" data-mdb-input-init>
                    <input type="email" class="form-control" id="validationTooltip04" name="email" :value="old('email')" required   autocomplete="off"/>
                    <label for="validationTooltip04" class="form-label">Email</label>
                    <!-- <div class="valid-tooltip">Email is required</div> -->
                    <div class="invalid-tooltip">Email is required</div>

                  </div>
                  <div class="common-user">
                    <i class="fa-regular fa-envelope"></i>
                  </div>
                </div>
                <div class="col-md-10 position-relative">
                  <div class="form-outline" data-mdb-input-init>

                    <input type="password" id="password" name="password" class="form-control" id="validationTooltip5" value="" required  autocomplete="off"/>
                    <label for="validationTooltip05" class="form-label">Password</label>
                    <div class="invalid-tooltip">Password is required</div>
                  </div>
                  <div class="input-icon">
                    <i class="fa-regular fa-eye"></i>
                  </div>
                </div>
                <div class="col-md-10">
                  <div class="login-check-input">
                    <div class="form-check pb-0">
                      <!-- <input class="form-check-input" type="checkbox" value="" id="invalidCheck" required />
                      <label class="form-check-label" for="invalidCheck">Remember me
                      </label> -->

                    </div>
                    <div class="forgot-password-link desktop-view-forgot">
                      <a href="forgot.html">Forgot your password?</a>
                    </div>
                  </div>
                </div>
                <div class="col-lg-10 col-12">
                  <button class="btn common-primary-btn" type="submit" data-mdb-ripple-init>
                    <i class="fa-solid fa-lock"></i>Login</button>
                    <p class="password-link login-link">Don't have an account? <a class="p-link" href="{{ route('register') }}">Create
                        an Account</a>
                    </p>
                  <div class="forgot-password-link mobile-view-forgot">
                    <a href="forgot.html">Forgot your password?</a>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
        <!-- <div class="row">
          <div class="col-12" id="last-row">
            <div class="text-center login-link">
              <p class="password-link login-link">Don't have an account? <a class="p-link" href="{{ route('register') }}">Create
                  an Account</a>
              </p>
            </div>
          </div>
        </div> -->
      </div>
    </div>
  </main>
    <button id="backToTop" class="back-to-top">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20"
    height="20" fill="none" stroke="white" stroke-width="2"
    stroke-linecap="round" stroke-linejoin="round">
    <polyline points="18 15 12 9 6 15"></polyline>
    </svg>
    </button>

@endsection
