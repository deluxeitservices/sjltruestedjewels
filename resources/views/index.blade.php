  
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

           <!--  <div class="col-lg-2 col-sm-6 col-6 active">
              <div class="shop-card">
                <h5 class="ornament_ttl">Gold Bars</h5>
                <a href="#" class="cate_desc all_products_metal_filter">
                  <span class="cate_desc_inner_content">
                    <div class="highlight_portion"></div>
                    <div
                      class="gold-bars-img image-mask-effect pseudo common-shop-img">
                      <img src="./assets/image/gold-bars.png" alt>
                    </div>
                  </span>
                  <div><span class="discover_link">DISCOVER</span></div>
                </a>
              </div>
            </div>
            <div class="col-lg-2 col-sm-6 col-6">
              <div class="shop-card">
                <h5 class="ornament_ttl">Gold Coins</h5>
                <a href="#" class="cate_desc all_products_metal_filter"
                  data-metal-name="Gold" data-metal-id="1">
                  <span class="cate_desc_inner_content goldimg">
                    <div class="highlight_portion"></div>
                    <div
                      class="image-mask-effect-gold-coins pseudo common-shop-img">
                      <img src="./assets/image/gold-coin-img.png" alt>
                    </div>
                  </span>
                  <div><span class="discover_link">DISCOVER</span></div>
                </a>
              </div>
            </div>
            <div class="col-lg-2 col-sm-6 col-6">
              <div class="shop-card">
                <h5 class="ornament_ttl">Silver Bars</h5>
                <a href="#" class="cate_desc all_products_metal_filter"
                  data-metal-name="Platinum" data-metal-id="3">

                  <span class="cate_desc_inner_content silver-bars-sec">
                    <div class="highlight_portion"></div>
                    <div
                      class="image-mask-effect-silvar-bars pseudo common-shop-img">
                      <img src="./assets/image/silvar-bars-img.png" alt>
                    </div>
                  </span>
                  <div><span class="discover_link">DISCOVER</span></div>
                </a>
              </div>
            </div>
            <div class="col-lg-2 col-sm-6 col-6">
              <div class="shop-card">
                <h5 class="ornament_ttl">Silver Coins</h5>
                <a href="#" class="cate_desc all_products_metal_filter">
                  <span class="cate_desc_inner_content palladium">
                    <div class="highlight_portion"></div>
                    <div
                      class="image-mask-effect-silvar-coins pseudo common-shop-img">
                      <img src="./assets/image/coin-7.png" alt>
                    </div>
                  </span>
                  <div class="shop"><span
                      class="discover_link">DISCOVER</span></div>
                </a>
              </div>
            </div>
            <div class="col-lg-2 col-sm-6 col-6">
              <div class="shop-card">
                <h5 class="ornament_ttl">Platinum Coins</h5>
                <a href="#" class="cate_desc all_products_metal_filter">
                  <span class="cate_desc_inner_content palladium">
                    <div class="highlight_portion"></div>
                    <div
                      class="image-mask-effect-silvar-coins pseudo common-shop-img">
                      <img src="./assets/image/coin-5.png" alt>
                    </div>
                  </span>
                  <div class="shop"><span
                      class="discover_link">DISCOVER</span></div>
                </a>
              </div>
            </div>
            <div class="col-lg-2 col-sm-6 col-6">
              <div class="shop-card">
                <h5 class="ornament_ttl">Palldium Coins</h5>
                <a href="#" class="cate_desc all_products_metal_filter">
                  <span class="cate_desc_inner_content palladium">
                    <div class="highlight_portion"></div>
                    <div
                      class="image-mask-effect-silvar-coins pseudo common-shop-img">
                      <img src="./assets/image/coin-6.png" alt>
                    </div>
                  </span>
                  <div class="shop"><span
                      class="discover_link">DISCOVER</span></div>
                </a>
              </div>
            </div> -->
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

          <div class="row">
            <div class="new-arrivals-banner owl-carousel owl-theme ">
              <div class="item">
                <div class="product-card  h-100" data-label="BESTSELLER">
                  <div class="product-card-container">
                    <div class="product-img">
                      <a href="product-detail.html"> <img
                          src="./assets/image/coin-1.png" alt="Diamond Band"
                          class="img-fluid"></a>
                      <button class="wishlist-btn"><i
                          class="fa-regular fa-heart"></i></button>
                    </div>
                    <div class="product-info">
                      <small>Eternity Rings &nbsp; | &nbsp; SKU: CBR 123</small>
                      <div class="stock-box">
                        <h6 class="product-title">Diamond Band</h6>
                        <p><img src="./assets/image/right.svg">In Stock</p>
                      </div>
                      <div class="price-eyes-section">
                        <div>
                          <p class="product-price">From £950.00 </p>
                        </div>
                        <div>
                          <a href="#"><i
                              class="fa-solid fa-cart-arrow-down"></i></a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="item">
                <div class="product-card  h-100" data-label="BESTSELLER">
                  <div class="product-card-container">
                    <div class="product-img">
                      <a href="product-detail.html"><img
                          src="./assets/image/coin-2.png" alt="Diamond Band"
                          class="img-fluid"></a>
                      <button class="wishlist-btn"><i
                          class="fa-regular fa-heart"></i></button>
                    </div>
                    <div class="product-info">
                      <small>Eternity Rings &nbsp; | &nbsp; SKU: CBR 123</small>
                      <div class="stock-box">
                        <h6 class="product-title">Diamond Band</h6>
                        <p><img src="./assets/image/right.svg">In Stock</p>
                      </div>
                      <div class="price-eyes-section">
                        <div>
                          <p class="product-price">From £950.00 </p>
                        </div>
                        <div>
                          <a href="#"><i
                              class="fa-solid fa-cart-arrow-down"></i></a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="item">
                <div class="product-card  h-100" data-label="BESTSELLER">
                  <div class="product-card-container">
                    <div class="product-img">
                      <img src="./assets/image/coin-3.png" alt="Diamond Band"
                        class="img-fluid">
                      <button class="wishlist-btn"><i
                          class="fa-regular fa-heart"></i></button>
                    </div>
                    <div class="product-info">
                      <small>Eternity Rings &nbsp; | &nbsp; SKU: CBR 123</small>
                      <div class="stock-box">
                        <h6 class="product-title">Diamond Band</h6>
                        <p><img src="./assets/image/cart.png">Pre Order</p>
                      </div>
                      <div class="price-eyes-section">
                        <div>
                          <p class="product-price">From £950.00 </p>
                        </div>
                        <div>
                          <a href="#"><i
                              class="fa-solid fa-cart-arrow-down"></i></a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="item">
                <div class="product-card  h-100" data-label="BESTSELLER">
                  <div class="product-card-container">
                    <div class="product-img">
                      <img src="./assets/image/coin-4.png" alt="Diamond Band"
                        class="img-fluid">
                      <button class="wishlist-btn"><i
                          class="fa-regular fa-heart"></i></button>
                    </div>
                    <div class="product-info">
                      <small>Eternity Rings &nbsp; | &nbsp; SKU: CBR 123</small>

                      <div class="stock-box">
                        <h6 class="product-title">Diamond Band</h6>
                        <p><img src="./assets/image/cart.png"> Out Of Stock</p>
                      </div>
                      <div class="price-eyes-section">
                        <div>
                          <p class="product-price">From £950.00 </p>
                        </div>
                        <div>
                          <a href="#"><i
                              class="fa-solid fa-cart-arrow-down"></i></a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="item">
                <div class="product-card  h-100" data-label="BESTSELLER">
                  <div class="product-card-container">
                    <div class="product-img">
                      <img src="./assets/image/coin-5.png" alt="Diamond Band"
                        class="img-fluid">
                      <button class="wishlist-btn"><i
                          class="fa-regular fa-heart"></i></button>
                    </div>
                    <div class="product-info">
                      <small>Eternity Rings &nbsp; | &nbsp; SKU: CBR 123</small>
                      <div class="stock-box">
                        <h6 class="product-title">Diamond Band</h6>
                        <p><img src="./assets/image/outof_stock.svg">Out Of
                          Stock</p>
                      </div>
                      <div class="price-eyes-section">
                        <div>
                          <p class="product-price">From £950.00 </p>
                        </div>
                        <div>
                          <a href="#"><i
                              class="fa-solid fa-cart-arrow-down"></i></a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="item">
                <div class="product-card  h-100" data-label="BESTSELLER">
                  <div class="product-card-container">
                    <div class="product-img">
                      <img src="./assets/image/coin-6.png" alt="Diamond Band"
                        class="img-fluid">
                      <button class="wishlist-btn"><i
                          class="fa-regular fa-heart"></i></button>
                    </div>
                    <div class="product-info">
                      <small>Eternity Rings &nbsp; | &nbsp; SKU: CBR 123</small>
                      <div class="stock-box">
                        <h6 class="product-title">Diamond Band</h6>
                        <p><img src="./assets/image/awaiting_stock.svg">Low
                          Stock</p>
                      </div>
                      <div class="price-eyes-section">
                        <div>
                          <p class="product-price">From £950.00 </p>
                        </div>
                        <div>
                          <a href="#"><i
                              class="fa-solid fa-cart-arrow-down"></i></a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="item">
                <div class="product-card  h-100" data-label="BESTSELLER">
                  <div class="product-card-container">
                    <div class="product-img">
                      <img src="./assets/image/coin-7.png" alt="Diamond Band"
                        class="img-fluid">
                      <button class="wishlist-btn"><i
                          class="fa-regular fa-heart"></i></button>
                    </div>
                    <div class="product-info">
                      <small>Eternity Rings &nbsp; | &nbsp; SKU: CBR 123</small>
                      <div class="stock-box">
                        <h6 class="product-title">Diamond Band</h6>
                        <p><img src="./assets/image/awaiting_stock.svg">Low
                          Stock</p>
                      </div>
                      <div class="price-eyes-section">
                        <div>
                          <p class="product-price">From £950.00</p>
                        </div>
                        <div>
                          <a href="#"><i
                              class="fa-solid fa-cart-arrow-down"></i></a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
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
              <div class="sell-btn"><a href="sell-now.html"><button
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
                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-6">
                  <div class="product-card  h-100" data-label="BESTSELLER">
                    <div class="product-img">
                      <a href="product-detail.html"><img
                          src="./assets/image/coin-1.png" alt="Diamond Band"
                          class="img-fluid"></a>
                      <button class="wishlist-btn"><i
                          class="fa-regular fa-heart"></i></button>
                    </div>
                    <div class="product-info">
                      <small>Eternity Rings &nbsp; | &nbsp; SKU: CBR 123</small>
                      <div class="stock-box">
                        <h6 class="product-title">Diamond Band</h6>
                        <p><img src="./assets/image/awaiting_stock.svg">Low
                          Stock</p>
                      </div>
                      <div class="price-eyes-section">
                        <div>
                          <p class="product-price">From £950.00 </p>
                        </div>
                        <div>
                          <a href="#"><i
                              class="fa-solid fa-cart-arrow-down"></i></a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-6">
                  <div class="product-card  h-100" data-label="BESTSELLER">
                    <div class="product-img">
                      <img src="./assets/image/coin-2.png" alt="Diamond Band"
                        class="img-fluid">
                      <button class="wishlist-btn"><i
                          class="fa-regular fa-heart"></i></button>
                    </div>
                    <div class="product-info">
                      <small>Eternity Rings &nbsp; | &nbsp; SKU: CBR 123</small>
                      <div class="stock-box">
                        <h6 class="product-title">Diamond Band</h6>
                        <p><img src="./assets/image/awaiting_stock.svg">Low
                          Stock</p>
                      </div>
                      <div class="price-eyes-section">
                        <div>
                          <p class="product-price">From £950.00 </p>
                        </div>
                        <div>
                          <a href="#"><i
                              class="fa-solid fa-cart-arrow-down"></i></a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-6">
                  <div class="product-card  product-card h-100"
                    data-label="BESTSELLER">
                    <div class="product-img">
                      <img src="./assets/image/coin-3.png" alt="Diamond Band"
                        class="img-fluid">
                      <button class="wishlist-btn"><i
                          class="fa-regular fa-heart"></i></button>
                    </div>
                    <div class="product-info">
                      <small>Eternity Rings &nbsp; | &nbsp; SKU: CBR 123</small>
                      <div class="stock-box">
                        <h6 class="product-title">Diamond Band</h6>
                        <p><img src="./assets/image/outof_stock.svg">Out Of
                          Stock</p>
                      </div>
                      <div class="price-eyes-section">
                        <div>
                          <p class="product-price">From £950.00 </p>
                        </div>
                        <div>
                          <a href="#"><i
                              class="fa-solid fa-cart-arrow-down"></i></a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-6">
                  <div class="product-card  h-100" data-label="BESTSELLER">
                    <div class="product-img">
                      <img src="./assets/image/coin-4.png" alt="Diamond Band"
                        class="img-fluid">
                      <button class="wishlist-btn"><i
                          class="fa-regular fa-heart"></i></button>
                    </div>
                    <div class="product-info">
                      <small>Eternity Rings &nbsp; | &nbsp; SKU: CBR 123</small>
                      <div class="stock-box">
                        <h6 class="product-title">Diamond Band</h6>
                        <p><img src="./assets/image/outof_stock.svg">Out Of
                          Stock</p>
                      </div>
                      <div class="price-eyes-section">
                        <div>
                          <p class="product-price">From £950.00 </p>
                        </div>
                        <div>
                          <a href="#"><i
                              class="fa-solid fa-cart-arrow-down"></i></a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-6">
                  <div class="product-card  h-100" data-label="BESTSELLER">
                    <div class="product-img">
                      <img src="./assets/image/coin-5.png" alt="Diamond Band"
                        class="img-fluid">
                      <button class="wishlist-btn"><i
                          class="fa-regular fa-heart"></i></button>
                    </div>
                    <div class="product-info">
                      <small>Eternity Rings &nbsp; | &nbsp; SKU: CBR 123</small>
                      <div class="stock-box">
                        <h6 class="product-title">Diamond Band</h6>
                        <p><img src="./assets/image/cart.png">Pre Order</p>
                      </div>
                      <div class="price-eyes-section">
                        <div>
                          <p class="product-price">From £950.00 </p>
                        </div>
                        <div>
                          <a href="#"><i
                              class="fa-solid fa-cart-arrow-down"></i></a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-6">
                  <div class="product-card  h-100" data-label="BESTSELLER">
                    <div class="product-img">
                      <img src="./assets/image/coin-6.png" alt="Diamond Band"
                        class="img-fluid">
                      <button class="wishlist-btn"><i
                          class="fa-regular fa-heart"></i></button>
                    </div>
                    <div class="product-info">
                      <small>Eternity Rings &nbsp; | &nbsp; SKU: CBR 123</small>
                      <div class="stock-box">
                        <h6 class="product-title">Diamond Band</h6>
                        <p><img src="./assets/image/cart.png">Pre Order</p>
                      </div>
                      <div class="price-eyes-section">
                        <div>
                          <p class="product-price">From £950.00 </p>
                        </div>
                        <div>
                          <a href="#"><i
                              class="fa-solid fa-cart-arrow-down"></i></a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-6">
                  <div class="product-card  h-100" data-label="BESTSELLER">
                    <div class="product-img">
                      <img src="./assets/image/coin-7.png" alt="Diamond Band"
                        class="img-fluid">
                      <button class="wishlist-btn"><i
                          class="fa-regular fa-heart"></i></button>
                    </div>
                    <div class="product-info">
                      <small>Eternity Rings &nbsp; | &nbsp; SKU: CBR 123</small>
                      <div class="stock-box">
                        <h6 class="product-title">Diamond Band</h6>
                        <p><img src="./assets/image/awaiting_stock.svg">Low
                          Stock</p>
                      </div>
                      <div class="price-eyes-section">
                        <div>
                          <p class="product-price">From £950.00 </p>
                        </div>
                        <div>
                          <a href="#"><i
                              class="fa-solid fa-cart-arrow-down"></i></a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-6">
                  <div class="product-card  h-100" data-label="BESTSELLER">
                    <div class="product-img">
                      <img src="./assets/image/coin-8.png" alt="Diamond Band"
                        class="img-fluid">
                      <button class="wishlist-btn"><i
                          class="fa-regular fa-heart"></i></button>
                    </div>
                    <div class="product-info">
                      <small>Eternity Rings &nbsp; | &nbsp; SKU: CBR 123</small>
                      <div class="stock-box">
                        <h6 class="product-title">Diamond Band</h6>
                        <p><img src="./assets/image/awaiting_stock.svg">Low
                          Stock</p>
                      </div>
                      <div class="price-eyes-section">
                        <div>
                          <p class="product-price">From £950.00 </p>
                        </div>
                        <div>
                          <a href="#"><i
                              class="fa-solid fa-cart-arrow-down"></i></a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="product-listing-btn">
                  <a href="product-listing.html"><button href="#"
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
          $dots  = '';

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
              <div class="buy-now-btn"><button class="common-primary-btn">Buy
                  Now</button></div>
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