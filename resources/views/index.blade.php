  <!-- resources/views/home.blade.php -->
  @extends('layouts.app')

  @section('title', 'Home')
  @section('meta_description', 'Home')

  @section('content')
  <main class="home-main">
    <section class="shop-by-category" style="{{ $bannerStyle }}">
      <div class="container">
        <!-- <div class="row">
          <h4 class="common-title slide-in-top-right">Shop By Category</h4>
        </div> -->
        <div class="row categary_list_slider">

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
    <!-- services-section -->
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
    <!-- new-arrivals-section -->
    <section class="new-arrivals-section trending-products common-section">
      <h4 class="common-title">New Arrivals</h4>
      <div class="container-fluid">

        <!-- @if($apiError)
            <div class="alert alert-warning mb-3">
              Couldn’t load latest arrivals right now. Please try again later.
            </div>
          @endif
       -->
        <div class="row">
          <div class="new-arrivals-banner owl-carousel owl-theme">
            <?php $prefix = 'bullion'; ?>
            @forelse($newArrivals as $p)
            <div class="item">
              <div class="product-card h-100" data-label="NEW">
                <div class="product-card-container">
                  <div class="product-img">
                    <a href="{{ route('ext.product', ['category' => $prefix, 'slug' => $p['slug']]) }}" rel="noopener">
                      @if(!empty($p['image']))
                      <img src="{{ $p['image'] }}" alt="{{ $p['name'] ?? 'Product' }}" class="img-fluid">
                      @else
                      <img src="{{ asset('assets/image/placeholder.png') }}" alt="No image" class="img-fluid">
                      @endif
                    </a>
                    <!-- <button class="wishlist-btn"><i class="fa-regular fa-heart"></i></button> -->

                    @php
                    $isFavorited = in_array($p['external_id'], $favoritedIds);
                    @endphp
                    <button
                      class="wishlist-btn js-fav "
                      data-external-id="{{ $p['external_id'] }}"
                      data-prefix="{{ ($prefix) }}"
                      data-slug="{{ e($p['slug']) }}"
                      data-title="{{ e($p['title']) }}"
                      data-sku="{{ e($p['sku'] ?? '') }}"
                      data-image="{{ e($p['image'] ?? '') }}"
                      aria-label="Toggle favorite">
                      <i class=" fa-heart {{ $isFavorited ? 'fa-solid is-favorited' : 'fa-regular' }}"></i>
                    </button>
                  </div>

                  <div class="product-info">
                    <!--  <small>
                          @if(!empty($p['sku'])) SKU: {{ $p['sku'] }} @endif
                        </small> -->
                    <h6 class="product-title">WG:{{ number_format($p['weight_g'] ?? 0,3) }} g</h6>
                    <small>{{ $p['brand'] }} | SKU: {{ $p['sku'] }}</small>
                    <div class="stock-box">
                      <h6 class="product-title">{{ $p['title'] ?? '—' }}</h6>
                      @if($p['availability'] === 'pre_order')
                      <p><img src="/assets/image/awaiting_stock.svg">Pre Order</p>
                      @elseif($p['availability'] === 'in_stock')
                      <p><img src="/assets/image/right.svg">In Stock</p>
                      @else
                      <p><img src="/assets/image/outof_stock.svg">Sold Out</p>
                      @endif
                      <!-- @if(array_key_exists('in_stock', $p))
                            <p>
                              <img src="{{ asset('assets/image/right.svg') }}">
                              {{ $p['in_stock'] ? 'In Stock' : 'Out of Stock' }}
                            </p>
                          @endif -->
                    </div>

                    <div class="price-eyes-section">
                      <div>
                        @php
                        $cur = $p['currency'] ?? 'GBP';
                        $symbol = $cur === 'GBP' ? '£' : ($cur === 'USD' ? '$' : ($cur === 'EUR' ? '€' : $cur.' '));
                        @endphp

                        @if(!is_null($p['display_price']))

                        <span class="js-price product-price" data-id="{{ $p['external_id'] }}">
                          Less then {{ number_format($p['display_price'] ?? 0, 2) }}
                        </span>
                        <!-- <p class="product-price">From {{ $symbol }}{{ number_format((float)$p['display_price'], 2) }}</p> -->
                        @else
                        <p class="product-price">Price on request</p>
                        @endif
                      </div>

                      <div>
                        @if(!empty($p['url']))
                        <a href="{{ route('ext.product', ['category' => $prefix, 'slug' => $p['slug']]) }}" rel="noopener">
                          <i class="fa-solid fa-cart-arrow-down"></i>
                        </a>
                        @else
                        <a href="{{ route('ext.product', ['category' => $prefix, 'slug' => $p['slug']]) }}"><i class="fa-solid fa-cart-arrow-down"></i></a>
                        @endif
                      </div>
                    </div>
                  </div>

                </div>
              </div>
            </div>
            @empty
            {{-- Optional: a single placeholder card when no items --}}
            <div class="item">
              <div class="product-card h-100">
                <div class="product-card-container p-4 text-center">
                  <em>No new arrivals found.</em>
                </div>
              </div>
            </div>
            @endforelse

          </div>
        </div>
      </div>
    </section>

    <!-- sell-gold-modern -->
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
            <div class="sell-btn"><a href="{{ route('ext.catalog', ['category' => 'bullion']) }}"><button
                  class="common-primary-btn">Sell Now</button></a></div>
          </div>
        </div>
      </div>
    </section>

    <!-- product-lising-sectio -->
    <section
      class="product-lising-section new-arrivals-section common-section">
      <h4 class="common-title">Trending Products</h4>
      <div class="product-main-box">
        <div class="product-listing">
          <div class="container">
            <div class="row">

              @php
              // Simple currency symbol helper
              $symbol = fn($c) => match(strtoupper($c ?? 'GBP')) {
              'GBP' => '£', 'USD' => '$', 'EUR' => '€', default => ''
              };
              @endphp

              @foreach ($newtrending as $p)
              <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-6">
                <div class="product-card h-100"
                  @if(!empty($p['label'])) data-label="{{ e($p['label']) }}" @endif>
                  <div class="product-img">
                    <a href="{{ route('ext.product', ['category' => $prefix, 'slug' => $p['slug']]) }}">
                      <img
                        src="{{ $p['image'] ?? asset('assets/image/placeholder-product.png') }}"
                        alt="{{ e($p['title'] ?? 'Product') }}"
                        class="img-fluid">
                    </a>
                    <button class="wishlist-btn" data-sku="{{ e($p['sku'] ?? '') }}">
                      <i class="fa-regular fa-heart"></i>
                    </button>
                  </div>

                  <div class="product-info">
                    <small>
                      {{ $p['brand'] ?? Str::title($p['metal'] ?? '') ?: '—' }}
                      &nbsp; | &nbsp; SKU: {{ $p['sku'] ?? '—' }}
                    </small>

                    <div class="stock-box">
                      <h6 class="product-title">{{ $p['title'] ?? 'Untitled' }}</h6>
                      <p>
                        @if(isset($p['in_stock']) && $p['in_stock'])
                        <img src="{{ asset('assets/image/in_stock.svg') }}" alt="">
                        In Stock
                        @else
                        <img src="{{ asset('assets/image/awaiting_stock.svg') }}" alt="">
                        {{ ucfirst($p['availability'] ?? 'Low Stock') }}
                        @endif
                      </p>
                    </div>

                    <div class="price-eyes-section">
                      <div>
                        <p class="product-price">
                          @php
                          $dp = $p['display_price'] ?? $p['price'] ?? null;
                          $cur = $p['currency'] ?? 'GBP';
                          @endphp

                          @if(is_numeric($dp))
                          Less then {{ $symbol($cur) }}{{ number_format((float)$dp, 2) }}
                          @else
                          <span class="text-muted">Price on request</span>
                          @endif
                        </p>
                      </div>
                      <div>
                        <!-- <a href="{{ $p['external_id'] ? route('cart.add', $p['external_id']) : '#' }}">
                            <i class="fa-solid fa-cart-arrow-down"></i>
                          </a> -->
                        @if(!empty($p['url']))
                        <a href="{{ route('ext.product', ['category' => $prefix, 'slug' => $p['slug']]) }}" rel="noopener">
                          <i class="fa-solid fa-cart-arrow-down"></i>
                        </a>
                        @else
                        <a href="{{ route('ext.product', ['category' => $prefix, 'slug' => $p['slug']]) }}"><i class="fa-solid fa-cart-arrow-down"></i></a>
                        @endif
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              @endforeach


            </div>
            <div class="row">
              <div class="product-listing-btn">
                <a href="{{ route('ext.catalog', ['category' => 'bullion']) }}"><button href="#"
                    class="common-primary-btn">View More</button></a>
              </div>
            </div>
          </div>
        </div>

      </div>
    </section>
    <section class="inspire-section">
      <div class="our_legacy-section">
        <div class="section-heading text-center">
          <div class="sub-title">
            Our Legacy
          </div>
          <h4 class="common-title">
            Inspiring excellence in
            the industry since
          </h4>
        </div>
        <!-- <h3 class="boujee-text">1986</h3> -->
        @php
        $cards = '';
        $dots = '';

        foreach($result_home_process as $index => $resulthomeprocess) {
        // crew card
        $cards .= '
        <div class="crew-card" data-index="'.$index.'">
          <img src="'.asset($base . '/upload/features/' . $resulthomeprocess->image).'" alt="'.$resulthomeprocess->name.'">
        </div>';

        // crew dot
        $dots .= '
        <div class="crew-dot '.($index == 0 ? 'active' : '').'" data-index="'.$index.'"></div>';
        }
        @endphp
        <div class="container-fluid">

          <div class="crew-carousel">
            <button class="crew-arrow crew-left">‹</button>
            <div class="crew-track">
              {!! $cards !!}
            </div>
            <button class="crew-arrow crew-right">›</button>
          </div>

          <div class="crew-info">
            <h2 class="crew-name">Discover More</h2>
            <p class="crew-role">Gold</p>
          </div>
          <div class="crew-dots">
            {!! $dots !!}
          </div>
          <div class="col-md-12">

            <div class="buy-now-btn"><a href="{{ route('ext.catalog', ['category' => 'bullion']) }}"><button class="common-primary-btn">Buy
                  Now</button></a></div>
          </div>
        </div>
      </div>
    </section>
    <!-- video_section -->
    <section class="video_section">
      <div class="d-flex flex-column video-section-container">
        <div class="container video_section_content">
          <div
            class="d-flex flex-grow-1 align-items-center justify-content-center flex-column">
            <div class="content">
              <div class="video_section_titles">
                <h6 class="section_sub_ttl">Dive into the enchanting world of
                  gold</h6>
                <h2 class="section_ttl">Explore the art of minting precious
                  metals</h2>
              </div>
              <div class="play-btn-div">
                <a href="javascript:void(0)" class="play-button">
                  <img
                    src="./assets/image/play-button.png"
                    alt="play-button" />
                </a>
              </div>
            </div>

            @if($resulthome && $resulthome->image != "")
            <video width="1920" height="1080" id="ID"
              poster="{{ asset($base . 'upload/process/' . $resulthome->image2) }}" controls>
              <source src="{{ asset($base . 'upload/process/' . $resulthome->image) }}" type="video/mp4">
              Your browser does not support the video tag.
            </video>
            @else
            <p>No video uploaded</p>
            @endif
            <!--   <video width="1920" height="1080" id="ID"
                poster="./assets/image/home-video-poster.png" controls>
                <source src="./assets/image/goldbank-video.mp4"
                  type="video/mp4">
                Your browser does not support the video tag.
              </video> -->

          </div>
        </div>
      </div>
    </section>

    <!-- newsroom-section -->
    <section class="common-section newsroom-section">
      <div class="container">
        <h4 class="common-title text-left">Newsroom</h4>

        <div class="row align-items-center">
          <div
            class="col-xl-6 col-lg-6 col-md-12 col-12 left-newsroom-column">
            <div class="left-newsroom-content">

              @foreach($testimonials as $testimonial)
              <div class="newsroom-img-section">
                <div class="newsoorm-icon-box">
                  <span class="newsroom-icon"><i
                      class="fa-solid fa-users"></i></span>
                </div>
                <div class="newsroom-left-content">
                  <h6>Market Commentary</h6>
                  <p>Our regular market reports provide commentary and outlook
                    on the issues that matter for bullion
                    investors.</p>
                  <!-- <div class="read-more-btn"><a href="#">Read More</a></div> -->
                </div>
              </div>
              @endforeach
            </div>
          </div>
          <div class="col-xl-6 col-lg-6 col-md-12 right-newsroom-colum">
            <h6>Latest Market Comment</h6>
            <div class="newsroom-content">

              <span>Is silver’s pent-up bullishness ready to be
                unleashed?</span>
              <p>12 June 2025As US President Donald Trump plays havoc with
                global trade there is a risk that other
                countries stand up to Trump and the currently dire situation
                deteriorates</p>
            </div>
            <div class="newsroom-content">
              <span>Is silver’s pent-up bullishness ready to be
                unleashed?</span>
              <p>12 June 2025As US President Donald Trump plays havoc with
                global trade there is a risk that other
                countries stand up to Trump and the currently dire situation
                deteriorates</p>
            </div>
            <div class="newsroom-content">
              <span>Is silver’s pent-up bullishness ready to be
                unleashed?</span>
              <p>12 June 2025As US President Donald Trump plays havoc with
                global trade there is a risk that other
                countries stand up to Trump and the currently dire situation
                deteriorates</p>
            </div>
          </div>
        </div>
      </div>
    </section>

  </main>
  @endsection