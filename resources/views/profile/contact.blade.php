@extends('layouts.app')
@section('title', 'SJL')
@section('content')
<main class="contact-us-page">
    <section class="common-banner-section">
        <div class="common-banner-content">
            <h2>Contact Us</h2>
            <p>
                We’re here to assist with any inquiries or support you need. Fill out the contact form, and our team will
                respond promptly.</p>
        </div>
    </section>

    <section class="contact-us-form-section" id="contact">
        <div class="container">
            <div class="row form-container">
                <div class="col-md-4 left-conntact-form-img">
                    <div class="contact-us-img"></div>
                </div>
                <div class="col-md-8">
                    <div class="get-contact-form">
                        <div class="card-pattern"></div>
                        <div class="form-title">
                            <h3><i class="fas fa-comments"></i>Get In Touch</h3>
                        </div>

                        <form class="needs-validation register-form" method="POST" action="{{ route('contact.store') }}" novalidate>
                            @csrf
                            <div class="row g-3">
                                <div class="col-md-12 position-relative">
                                    <div class="form-outline" data-mdb-input-init>
                                        <input type="text" class="form-control" id="name" name="name" value="" required />
                                        <label for="validationTooltip00" class="form-label">Name</label>

                                        <div class="invalid-tooltip">Name is required</div>
                                    </div>
                                    <div class="common-user">
                                        <i class="fa-solid fa-user"></i>
                                    </div>
                                </div>
                                <div class="col-md-12 position-relative">
                                    <div class="form-outline" data-mdb-input-init>
                                        <input type="text" class="form-control" id="mobile" name="mobile" value="" required />
                                        <label for="validationTooltip03" class="form-label">Mobile Number</label>
                                        <div class="invalid-tooltip">Mobile Number is required</div>
                                    </div>
                                    <div class="common-user">
                                        <i class="fa-solid fa-phone"></i>
                                    </div>
                                </div>
                                <div class="col-md-12 position-relative">
                                    <div class="form-outline" data-mdb-input-init>
                                        <input type="email" class="form-control" id="email" name="email" value="" required />
                                        <label for="validationTooltip04" class="form-label">Email</label>
                                        <div class="invalid-tooltip">Email is required</div>
                                    </div>
                                    <div class="common-user">
                                        <i class="fa-regular fa-envelope"></i>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-outline" data-mdb-input-init>
                                        <textarea class="form-control" id="message" name="message" rows="4"></textarea>
                                        <label class="form-label" for="textAreaExample">Message</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="contact-submit-btn">
                                        <a href="#"><button class="btn common-primary-btn" type="submit" data-mdb-ripple-init><i class="fa-solid fa-paper-plane"></i>Submit</button></a>
                                    </div>
                                </div>
                            </div>
                        </form>
                        @if (session('status'))
                        <div class="alert alert-success mt-3">{{ session('status') }}</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection