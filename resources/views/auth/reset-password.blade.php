@extends('layouts.app')
@section('title', 'SJL')

@section('content')
<main>
    <div class="forgot-passwrod-page" >
        <div class="container">
            {{-- Header --}}
            <div class="row">
                <div class="col-md-12">
                    <h2 class="common-title">Reset Password</h2>
                    <p>Set a new password for your account.</p>

                    @if ($errors->any())
                        <div class="alert alert-danger mt-3">
                            <ul class="m-0">
                                @foreach ($errors->all() as $e)
                                    <li>{{ $e }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if (session('status'))
                        <div class="alert alert-success mt-3">{{ session('status') }}</div>
                    @endif
                </div>
            </div>

            <div class="row forgot-passwrod-row">
                <div class="col-md-5 col-12">
                    <div class="forgot-password-img"></div>
                </div>

                <div class="col-md-7 col-12">
                    <form method="POST" action="{{ route('password.store') }}" class="needs-validation" novalidate>
                        @csrf
                        <!-- Password Reset Token -->
                        <input type="hidden" name="token" value="{{ request()->route('token') }}">

                        <div class="row g-3 justify-content-center">
                            <!-- Email -->
                            <div class="col-md-10 col-12 position-relative">
                                <div class="form-outline">
                                    <input
                                        type="email"
                                        class="form-control"
                                        id="email"
                                        name="email"
                                        value="{{ old('email', request('email')) }}"
                                        required
                                        autocomplete="username" readonly
                                    />
                                    <label for="email" class="form-label">Email</label>
                                    <div class="invalid-tooltip">Email is required</div>
                                </div>
                                <div class="common-user">
                                    <i class="fa-regular fa-envelope"></i>
                                </div>
                                @error('email')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- New Password -->
                            <div class="col-md-10 col-12 position-relative">
                                <div class="form-outline">
                                    <input
                                        type="password"
                                        class="form-control"
                                        id="password"
                                        name="password"
                                        required
                                        autocomplete="new-password"
                                        placeholder="New password"
                                    />
                                    <label for="password" class="form-label">New Password</label>
                                    <div class="invalid-tooltip">New password is required</div>
                                </div>
                                <div class="common-user">
                                    <i class="fa-solid fa-key"></i>
                                </div>
                                @error('password')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Confirm Password -->
                            <div class="col-md-10 col-12 position-relative">
                                <div class="form-outline">
                                    <input
                                        type="password"
                                        class="form-control"
                                        id="password_confirmation"
                                        name="password_confirmation"
                                        required
                                        autocomplete="new-password"
                                        placeholder="Confirm new password"
                                    />
                                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                                    <div class="invalid-tooltip">Please confirm your new password</div>
                                </div>
                                <div class="common-user">
                                    <i class="fa-solid fa-key"></i>
                                </div>
                                @error('password_confirmation')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-lg-10 col-12">
                                <button class="btn common-primary-btn" type="submit">
                                    <i class="fa-solid fa-rotate"></i> Reset Password
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

        </div>
    </div>
</main>
@endsection
