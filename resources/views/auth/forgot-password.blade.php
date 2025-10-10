@extends('layouts.app')
@section('title', 'SJL')

@section('content')
<main>
    <div class="forgot-passwrod-page">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="common-title">Forgot Password</h2>
                    <p>Enter your registered email address and you will get a link to reset your password.</p>

                    @if (session('status'))
                        <div class="alert alert-success mt-3">{{ session('status') }}</div>
                    @endif

                    @error('email')
                        <div class="alert alert-danger mt-3">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row forgot-passwrod-row">
                <div class="col-md-5 col-12">
                    <div class="forgot-password-img"></div>
                </div>

                <div class="col-md-7 col-12">
                    <form class="needs-validation forgot-password-form" method="POST" action="{{ route('password.email') }}" novalidate>
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-10 col-12 position-relative">
                                <div class="form-outline">
                                    <input type="email" class="form-control" id="email" name="email" required />
                                    <label for="email" class="form-label">Email</label>
                                    <div class="invalid-tooltip">Email is required</div>
                                </div>
                                <div class="common-user">
                                    <i class="fa-regular fa-envelope"></i>
                                </div>
                            </div>

                            <div class="col-lg-10 col-12">
                                <button class="btn common-primary-btn" type="submit">
                                    <i class="fa-solid fa-envelope"></i> Send Link
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- <div class="text-center forgot-link mt-3">
                        <p class="password-link forgot-password-link">
                            Remembered your credentials?
                            <a class="p-link" href="{{ route('login') }}">Back to Login</a>
                        </p>
                    </div> -->
                </div>
                
            </div>
            
            <div class="row">
                <div class="col-12" id="last-row">
                    <div class="text-center forgot-link">
                        <p class="password-link forgot-password-link">Remembered your credentials? <a class="p-link"
                                href="{{ route('login') }}">Back to Login</a>
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</main>
@endsection
