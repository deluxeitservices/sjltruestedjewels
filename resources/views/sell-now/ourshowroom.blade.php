@extends('layouts.app')
@section('title','Sell Gold')

@section('content')
 <main class="our-showroom-page">
      <section class="common-banner-section">
        <div class="common-banner-content">
          <h2>Our Showrooms</h2>
          <p>
            At SLJ Trusted Jewels, we specialise in pre-owned jewellery and
            luxury treasures.
            Our curated selection ensures authenticity, sophistication, and
            outstanding value.</p>
        </div>
      </section>
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
      <section class="about-us-section common-section">
        <div class="container">
          <div class="row">
            <div class="col-md-6 col-12 first-colomn-about">
              <span>
                Elegantly Crafted with Red Gemstones and Pearls
              </span>
              <h4 class="common-title">Exquisite Traditional Gold Jewellery Set
              </h4>
              <p>This beautiful gold Jewellery set reflects the richness of
                traditional artistry. The necklace features
                multiple layers of finely crafted gold beads, highlighted by
                sparkling pearls and bold red gemstones at
                the center. Complemented by matching earrings, this set is ideal
                for special events and festive occasions,
                adding a regal and timeless elegance to your ensemble.</p>
             <a href="{{ route('ext.catalog', ['category' => 'bullion']) }}" aria-label="Shop gold bars at live market rates">
                                       <button
                                    class="common-primary-btn">
                                      Buy Now
                                    </button>
                                    </a>
            </div>
            <div class="col-md-6 col-12 second-colomn-about">
              <div class="about-us-img">
                <img src="./assets/image/ourshoroom.svg" class="img-fluid">
              </div>
            </div>
          </div>

        </div>
      </section>
      <!-- <section class="showroom-banner common-section">
        <div class="container">
          <div class="row">
            <div class="col-md-12">
              <h6>Explore Our London Showrooms</h6>
              <p>Step into our London locations to discover a carefully curated selection of pre-owned and fine jewellery. At SLJ Trusted Jewels, we pride ourselves on offering pieces that blend sophistication, authenticity, and lasting beauty.</p>
            </div>
          </div>
        </div>
      </section> -->
      <section class="common-section our-showroom-section">
        <div class="container">
          <div class="row">
            <div class="col-md-12">
              <h4 class="common-title text-left">Our Showroom</h4>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-4 col-md-12 col-12">
              <div class="card">
                <img src="./assets/image/our-shoroom-5.jpg"
                  class="card-img-top" alt="showroom" />
                <div class="middle">
                  <div class="image-logo">
                    <img src="./assets/image/logo-dark.svg">
                  </div>
                </div>
                <div class="card-body">
                  <h5 class="card-title">SLJ Trusted Jewels</h5>
                  <h6><i class="fa-solid fa-location-arrow"></i> Opening
                    Hours</h6>
                  <p class="card-text">
                  Unit 2,281 Green Street(on Shafresbury Road Side) London, E7 8PD
                  </p>
                  <p class="card-text">
                    <h6><i class="fa-regular fa-clock"></i>Opening Hours</h6>
                    <small class="timeing-text">
                      Monday - Sunday: 10:00 AM - 6:00 PM</small>
                  </p>
                </div>
              </div>
            </div>
            <div class="col-lg-4 col-md-12 col-12">
              <div class="card">
                <img src="./assets/image/our-showroom-1.svg"
                  class="card-img-top" alt="showroom" />
                  <div class="middle">
                  <div class="image-logo">
                    <img src="./assets/image/logo-dark.svg">
                  </div>
                </div>
                <div class="card-body">
                  <h5 class="card-title">SLJ Trusted Jewels</h5>
                  <h6><i class="fa-solid fa-location-arrow"></i> Opening
                    Hours</h6>
                  <p class="card-text">
                  Unit 2,281 Green Street(on Shafresbury Road Side) London, E7 8PD
                  </p>
                  <p class="card-text">
                    <h6><i class="fa-regular fa-clock"></i>Opening Hours</h6>
                    <small class="timeing-text">
                      Monday - Sunday: 10:00 AM - 6:00 PM</small>
                  </p>
                </div>
              </div>
            </div>
            <div class="col-lg-4 col-md-12 col-12">
              <div class="card">
                <img src="./assets/image/ourshowroom-3.svg"
                  class="card-img-top" alt="showroom" />
                  <div class="middle">
                  <div class="image-logo">
                    <img src="./assets/image/logo-dark.svg">
                  </div>
                </div>
                <div class="card-body">
                  <h5 class="card-title">SLJ Trusted Jewels</h5>
                  <h6><i class="fa-solid fa-location-arrow"></i> Opening
                    Hours</h6>
                  <p class="card-text">
                    Unit 2,281 Green Street(on Shafresbury Road Side) London, E7 8PD
                  </p>
                  <p class="card-text">
                    <h6><i class="fa-regular fa-clock"></i>Opening Hours</h6>
                    <small class="timeing-text">
                      Monday - Sunday: 10:00 AM - 6:00 PM</small>
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <section class="about-us-section bottom-about-us">
        <div class="container">
          <div class="row">
            <div class="col-md-6">
              <div class="about-us-img">
                <img src="./assets/image/ourshoroom-about-2.svg" class="img-fluid">
              </div>
            </div>
            <div class="col-md-6 col-12 second-colomn-about">
              <span>
                Masterfully Adorned with Crimson Gemstones and Pearls
              </span>
              <h4 class="common-title">Expertise

              </h4>
              <p>At SJL Trusted Jewels, we guarantee authenticity,
                superior quality, expert craftsmanship,
                personalized service, and a 12-month warranty with every
                purchase. Our collection features some of the
                most exquisite pre-owned jewellery and luxury watches available
                worldwide.</p>
              <a href="{{ route('ext.catalog', ['category' => 'bullion']) }}" aria-label="Shop gold bars at live market rates">
                                       <button
                                    class="common-primary-btn">
                                      Buy Now
                                    </button>
                                    </a>
            </div>
          </div>

        </div>
      </section>
      <section class="gallary-about-us">
      <div class="container">
        <div class="property-container">
          <div class="container">
            <div class="property-wrapper">
              <h4 class="common-title">About US Gallary</h4>
              <div class="property-slide">
                <div class="property-item">
                  <a href="#">
                    <div class="property-img">
                      <img src="./assets/image/coins-gold-bars-scattered-table.jpg" alt="Featured Property" />
                    </div>

                  </a>
                </div>
                <div class="property-item">
                  <a href="#">
                    <div class="property-img">
                      <img src="./assets/image/inspire-2.png" alt="Featured Property" />
                    </div>

                  </a>
                </div>
                <div class="property-item">
                  <a href="#">
                    <div class="property-img">
                      <img src="./assets/image/inspire-5.jpg" alt="Featured Property" />
                    </div>

                  </a>
                </div>
                <div class="property-item">
                  <a href="#">
                    <div class="property-img">
                      <img src="./assets/image/golden-rmb-coins-cloth-bag.jpg" alt="Featured Property" />
                    </div>

                  </a>
                </div>
                <div class="property-item">
                  <a href="#">
                    <div class="property-img">
                      <img src="./assets/image/goldbar-2.jpg" alt="Featured Property" />
                    </div>

                  </a>
                </div>
                <div class="property-item">
                  <a href="#">
                    <div class="property-img">
                      <img src="./assets/image/still-life-dollar-coins-piles.jpg" alt="Featured Property" />
                    </div>

                  </a>
                </div>

              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
     
    </main>
@endsection
