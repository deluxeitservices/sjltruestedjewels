@extends('layouts.app')
@section('title','Sell Gold')

@section('content')
<main class="sell-gold-page-main">
            <section class="common-banner-section">
                <div class="common-banner-content">
                    <h2>Sell Gold</h2>
                    <p>
                      Sell Gold in London | Best Prices & Instant Payment
                    </p>
                    <a href="{{ route('sell.index') }}">
                        <button class="common-primary-btn mt-3">Sell Now</button>
                    </a>
                </div>
            </section>
            <!-- service section -->
            <section class="services-section">
                <div class="container">
                    <div class="row">
                        <div class="col-md-3 col-sm-6 col-6">
                            <div class="services-card">
                                <img src="./assets/image/service-icon-1.svg">
                                <div class="service-content">
                                    <h6>Free Easy Returns</h6>
                                    <p>Return to 7 days</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 col-6">
                            <div class="services-card">
                                <img src="./assets/image/service-icon-2.svg">
                                <div class="service-content">
                                    <h6>Free Delivery Monday</h6>
                                    <p>Orders over £499</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 col-6">
                            <div class="services-card">
                                <img src="./assets/image/service-icon-3.svg">
                                <div class="service-content">
                                    <h6>All Day Support</h6>
                                    <p>24/7 Support care</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 col-6">
                            <div class="services-card">
                                <img src="./assets/image/service-icon-4.svg">
                                <div class="service-content">
                                    <h6>Secure checkouts</h6>
                                    <p>100% protected by Paypal</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- gold Leading -->
            <section class="gold-leading-section common-section">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <div class="leading-title">
                                <h4 class="common-title">Sell Gold to the UK's Leading Gold Buyerss</h4>
                                <p>
                                    Sell gold by post or in-person. Sell gold jewellery, gold coins and gold bars, watches and more.
                           Clear pricing with no hidden charges. Track your sale online in real-time.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="leading-card-box">
                        <div class="row">
                            <div class="col-md-4 col-12">
                                <div class="leading-control-title">
                                    <h6>Popular Gold Coins</h6>
                                    <h6>We pay up to</h6>
                                </div>
                                <div class="main-leading-box slider-down-load">
                                    <div class="leading-img-box">
                                        <img src="./assets/image/coin-1.png">
                                        <a href="{{ route('sell.index') }}">
                                            Gold Sovereign Queen Elizabeth II Fifth Head (2016-2022)
                                        </a>
                                    </div>
                                    <div class="leadong-value">
                                        <a href="{{ route('sell.index') }}">£576.77</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="leading-control-title">
                                    <h6>Popular Gold Bars</h6>
                                    <h6>We pay up to</h6>
                                </div>
                                <div class="main-leading-box slider-down-load">
                                    <div class="leading-img-box">
                                        <img src="./assets/image/coin-2.png">
                                        <a href="{{ route('sell.index') }}">
                                            Gold Sovereign Queen Elizabeth II Fifth Head (2016-2022)
                                        </a>
                                    </div>
                                    <div class="leadong-value">
                                        <a href="{{ route('sell.index') }}">£576.77</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="leading-control-title">
                                    <h6>Scrap Gold</h6>
                                    <h6>We pay up to</h6>
                                </div>
                                <div class="main-leading-box slider-down-load">
                                    <div class="leading-img-box">
                                        <img src="./assets/image/coin-3.png">
                                        <a href="{{ route('sell.index') }}">
                                            Gold Sovereign Queen Elizabeth II Fifth Head (2016-2022)
                                        </a>
                                    </div>
                                    <div class="leadong-value">
                                        <a href="{{ route('sell.index') }}">£576.77</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="main-leading-box slider-down-load">
                                    <div class="leading-img-box">
                                        <img src="./assets/image/coin-1.png">
                                        <a href="{{ route('sell.index') }}">
                                            Gold Sovereign Queen Elizabeth II Fifth Head (2016-2022)
                                        </a>
                                    </div>
                                    <div class="leadong-value">
                                        <a href="{{ route('sell.index') }}">£576.77</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="main-leading-box slider-down-load">
                                    <div class="leading-img-box">
                                        <img src="./assets/image/coin-1.png">
                                        <a href="{{ route('sell.index') }}">
                                            Gold Sovereign Queen Elizabeth II Fifth Head (2016-2022)
                                        </a>
                                    </div>
                                    <div class="leadong-value">
                                        <a href="{{ route('sell.index') }}">£576.77</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="main-leading-box slider-down-load">
                                    <div class="leading-img-box">
                                        <img src="./assets/image/coin-1.png">
                                        <a href="{{ route('sell.index') }}">
                                            Gold Sovereign Queen Elizabeth II Fifth Head (2016-2022)
                                        </a>
                                    </div>
                                    <div class="leadong-value">
                                        <a href="{{ route('sell.index') }}">£576.77</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="main-leading-box slider-down-load">
                                    <div class="leading-img-box">
                                        <img src="./assets/image/coin-1.png">
                                        <a href="{{ route('sell.index') }}">
                                            Gold Sovereign Queen Elizabeth II Fifth Head (2016-2022)
                                        </a>
                                    </div>
                                    <div class="leadong-value">
                                        <a href="{{ route('sell.index') }}">£576.77</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="main-leading-box slider-down-load">
                                    <div class="leading-img-box">
                                        <img src="./assets/image/coin-1.png">
                                        <a href="{{ route('sell.index') }}">
                                            Gold Sovereign Queen Elizabeth II Fifth Head (2016-2022)
                                        </a>
                                    </div>
                                    <div class="leadong-value">
                                        <a href="{{ route('sell.index') }}">£576.77</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="main-leading-box slider-down-load">
                                    <div class="leading-img-box">
                                        <img src="./assets/image/coin-1.png">
                                        <a href="{{ route('sell.index') }}">
                                            Gold Sovereign Queen Elizabeth II Fifth Head (2016-2022)
                                        </a>
                                    </div>
                                    <div class="leadong-value">
                                        <a href="{{ route('sell.index') }}">£576.77</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="main-leading-box slider-down-load">
                                    <div class="leading-img-box">
                                        <img src="./assets/image/coin-1.png">
                                        <a href="{{ route('sell.index') }}">
                                            Gold Sovereign Queen Elizabeth II Fifth Head (2016-2022)
                                        </a>
                                    </div>
                                    <div class="leadong-value">
                                        <a href="{{ route('sell.index') }}">£576.77</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="sell-btn">
                                    <a href="{{ route('sell.index') }}">
                                        <button class="common-primary-btn">Sell Now</button>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- sell gold modern -->
            <section class="sell-gold-modern text-center">
              <div class="container">
                <!-- Heading -->
                <h4 class="common-title">The fastest way to sell your</h4>
                <h1 class="gold-text">GOLD</h1>

                <!-- Gold Image -->
                <div class="gold-img">
                  <img src="./assets/image/final-gold.gif" alt="Gold Coins">
                </div>

                <!-- Stats Row -->
                <div class="row stats">
                  <div class="col-md-4">
                    <div class="customer-card">
                      <div class="stat-box-shadow">
                        <img src="./assets/image/mone-flow.svg">
                      </div>
                      <div class="stat-box">
                        <h3 class="stat-number">£150m+</h3>
                        <p class="stat-label">Gold Bought</p>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="customer-card">
                      <div class="stat-box-shadow">
                        <img src="./assets/image/customer.svg">
                      </div>
                      <div class="stat-box">
                        <h3 class="stat-number">133k</h3>
                        <p class="stat-label">Happy Customers</p>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="customer-card">
                      <div class="stat-box-shadow">
                        <img src="./assets/image/bought.svg">
                      </div>
                      <div class="stat-box">
                        <h3 class="stat-number">3 mins</h3>
                        <p class="stat-label">Average Checkout</p>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="sell-btn"><a href="{{ route('sell.index') }}"><button
                          class="common-primary-btn">Sell Now</button></a></div>
                  </div>
                </div>
              </div>
            </section>
      
            <!-- wht we buy section -->
            <section class="what-we-buy-section common-section">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <div class="what-we-title">
                                <h4 class="common-title">What we buy</h4>
                                <p>
                                    Sell gold by post or in-person. Sell gold jewellery, gold coins and gold bars, watches and more. Clear pricing with no hidden charges. Track your sale online in real-time.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            <div class="what-buy-card">
                                <div class="buy-card-animation">
                                    <div class="buy-card-img">
                                        <img src="./assets/image/gold-coins.svg">
                                    </div>
                                    <div class="gold-box">
                                        <h3 class="gold-name">Gold Coins</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="what-buy-card">
                                <div class="buy-card-animation">
                                    <div class="buy-card-img">
                                        <img src="./assets/image/gold-bars.svg">
                                    </div>
                                    <div class="gold-box">
                                        <h3 class="gold-name">Gold Bars</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="what-buy-card">
                                <div class="buy-card-animation">
                                    <div class="buy-card-img">
                                        <img src="./assets/image/gold-jewellery.svg">
                                    </div>
                                    <div class="gold-box">
                                        <h3 class="gold-name">Gold Jewellery</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="what-buy-card">
                                <div class="buy-card-animation">
                                    <div class="buy-card-img">
                                        <img src="./assets/image/broken-jewellery.svg">
                                    </div>
                                    <div class="gold-box">
                                        <h3 class="gold-name">Broken Jewellery</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="what-buy-card">
                                <div class="buy-card-animation">
                                    <div class="buy-card-img">
                                        <img src="./assets/image/dental-gold.svg">
                                    </div>
                                    <div class="gold-box">
                                        <h3 class="gold-name">Dental Gold</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="what-buy-card">
                                <div class="buy-card-animation">
                                    <div class="buy-card-img">
                                        <img src="./assets/image/gold-watches.svg">
                                    </div>
                                    <div class="gold-box">
                                        <h3 class="gold-name">Gold Watches</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- shop-by-category -->
            <section class="shop-by-category">
            <div class="container">
              <!-- <div class="row">
              <h4 class="common-title slide-in-top-right">Shop By Category</h4>
            </div> -->
              <div class="row categary_list_slider">
                <?php 
                $base = config('app.backend_path');
                $result_home_services = homeservices();?>
                @foreach($result_home_services as $result_home_service)
                  <div class="col-lg-2 col-sm-6 col-6 {{ $loop->first ? 'active' : '' }}">
                      <div class="shop-card">
                          <h5 class="ornament_ttl">{{ $result_home_service->name }}</h5>
                          <a href="{{ $result_home_service->url }}" class="cate_desc all_products_metal_filter">
                              <span class="cate_desc_inner_content">
                                  <div class="highlight_portion"></div>
                                  <div class="{{ $result_home_service->image }} image-mask-effect pseudo common-shop-img">
                                     <img src="{{ asset($base . '/upload/services/' . $result_home_service->image) }}" alt="{{ $result_home_service->name }}">
                                  </div>
                              </span>
                              <div><span class="discover_link">{{ $result_home_service->button_text }}</span></div>
                          </a>
                      </div>
                  </div>
                  @endforeach

              </div>
            </div>
          </section>
          
            <!-- faq scction -->
            <section class="common-faq-section common-section">
                <div class="container">
                    <div class="row">
                        <h4 class="common-title">Frequently Asked Questions</h4>
                        <p class="faq-section-content">Find answers to common questions about our products and services</p>
                    </div>
                    <div class="faq-container">
                        <div class="faq-header">
                            <!-- Search Bar -->
                            <div class="search-container">
                                <div class="search-box">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                    <input type="text" id="searchInput" placeholder="Search questions...">
                                    <button class="clear-search" title="Clear search">
                                        <i class="fa-solid fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <!-- Category Filter -->
                            <div class="category-filter">
                                <button class="category-btn active" data-category="all">All</button>
                                <button class="category-btn" data-category="general">General</button>
                                <button class="category-btn" data-category="account">Account</button>
                                <button class="category-btn" data-category="billing">Billing</button>
                                <button class="category-btn" data-category="technical">Technical</button>
                            </div>
                        </div>
                        <div class="faq-content">
                            <!-- General Questions -->
                            <div class="faq-category" data-category="general">
                                <h2>General Questions</h2>
                                <div class="faq-item">
                                    <div class="faq-question">
                                        <h3>What services do you offer?</h3>
                                        <span class="faq-icon">
                                            <i class="fa-solid fa-plus"></i>
                                        </span>
                                    </div>
                                    <div class="faq-answer">
                                        <p>
                                            We offer a comprehensive range of services including web development, cloud solutions, digital
                                 marketing, and technical support. Our team of experts is dedicated to providing high-quality
                                 solutions
                                 tailored to your specific needs.
                                        </p>
                                    </div>
                                </div>
                                <div class="faq-item">
                                    <div class="faq-question">
                                        <h3>How can I contact customer support?</h3>
                                        <span class="faq-icon">
                                            <i class="fa-solid fa-plus"></i>
                                        </span>
                                    </div>
                                    <div class="faq-answer">
                                        <p>
                                            You can reach our customer support team through multiple channels: email at support@example.com,
                                 phone at +1 (555) 123-4567, or through our live chat feature available 24/7 on our website.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <!-- Account Questions -->
                            <div class="faq-category" data-category="account">
                                <h2>Account Management</h2>
                                <div class="faq-item">
                                    <div class="faq-question">
                                        <h3>How do I create an account?</h3>
                                        <span class="faq-icon">
                                            <i class="fa-solid fa-plus"></i>
                                        </span>
                                    </div>
                                    <div class="faq-answer">
                                        <p>
                                            Creating an account is simple! Click the "Sign Up" button in the top right corner, fill in your
                                 details, verify your email address, and you're ready to go. The entire process takes less than 2
                                 minutes.
                                        </p>
                                    </div>
                                </div>
                                <div class="faq-item">
                                    <div class="faq-question">
                                        <h3>How can I reset my password?</h3>
                                        <span class="faq-icon">
                                            <i class="fa-solid fa-plus"></i>
                                        </span>
                                    </div>
                                    <div class="faq-answer">
                                        <p>
                                            To reset your password, click on the "Forgot Password" link on the login page. Enter your email
                                 address, and we'll send you a password reset link. Follow the instructions in the email to create a
                                 new password.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <!-- Billing Questions -->
                            <div class="faq-category" data-category="billing">
                                <h2>Billing & Payments</h2>
                                <div class="faq-item">
                                    <div class="faq-question">
                                        <h3>What payment methods do you accept?</h3>
                                        <span class="faq-icon">
                                            <i class="fa-solid fa-plus"></i>
                                        </span>
                                    </div>
                                    <div class="faq-answer">
                                        <p>
                                            We accept all major credit cards (Visa, MasterCard, American Express), PayPal, and bank transfers.
                                 For enterprise customers, we also offer custom payment terms and invoicing options.
                                        </p>
                                    </div>
                                </div>
                                <div class="faq-item">
                                    <div class="faq-question">
                                        <h3>How do I update my billing information?</h3>
                                        <span class="faq-icon">
                                            <i class="fa-solid fa-plus"></i>
                                        </span>
                                    </div>
                                    <div class="faq-answer">
                                        <p>
                                            You can update your billing information by logging into your account, navigating to the "Billing"
                                 section, and clicking on "Update Payment Method". Here you can add, remove, or modify your payment
                                 details.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <!-- Technical Questions -->
                            <div class="faq-category" data-category="technical">
                                <h2>Technical Support</h2>
                                <div class="faq-item">
                                    <div class="faq-question">
                                        <h3>What are your system requirements?</h3>
                                        <span class="faq-icon">
                                            <i class="fa-solid fa-plus"></i>
                                        </span>
                                    </div>
                                    <div class="faq-answer">
                                        <p>
                                            Our platform is designed to work on all modern browsers (Chrome, Firefox, Safari, Edge) and
                                 devices.
                                 We recommend using the latest version of your preferred browser for the best experience.
                                        </p>
                                    </div>
                                </div>
                                <div class="faq-item">
                                    <div class="faq-question">
                                        <h3>How do I integrate your API?</h3>
                                        <span class="faq-icon">
                                            <i class="fa-solid fa-plus"></i>
                                        </span>
                                    </div>
                                    <div class="faq-answer">
                                        <p>
                                            We provide comprehensive API documentation and SDKs for various programming languages. You can find
                                 detailed integration guides, code examples, and API references in our Developer Portal.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- contact  us section -->
           
        </main>
@endsection
