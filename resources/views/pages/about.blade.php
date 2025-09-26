@extends('layouts.app')
@section('title', 'SJL')
@section('content')
<main class="about-us-page">
    <section class="common-banner-section">
      <div class="common-banner-content">
        <h2>About Us</h2>
        <p>
          Discover our story and the passion behind our work. We are committed to providing excellence
          and creativity. Explore our mission and the values that guide everything we do.</p>
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
            <p>This beautiful gold Jewellery set reflects the richness of traditional artistry. The necklace features
              multiple layers of finely crafted gold beads, highlighted by sparkling pearls and bold red gemstones at
              the center. Complemented by matching earrings, this set is ideal for special events and festive occasions,
              adding a regal and timeless elegance to your ensemble.</p>
            <button class="common-primary-btn">About Us</button>
          </div>
          <div class="col-md-6 col-12 second-colomn-about">
            <div class="about-us-img">
              <img src="./assets/image/about-us-new.jpg" class="img-fluid">
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
              <img src="./assets/image/terms.jpg" class="img-fluid">
            </div>
          </div>
          <div class="col-md-6 col-12 second-colomn-about">
            <span>
              Masterfully Adorned with Crimson Gemstones and Pearls
            </span>
            <h4 class="common-title">Expertise

            </h4>
            <p>At preowned luxuries Jewellers, we guarantee authenticity, superior quality, expert craftsmanship,
              personalized service, and a 12-month warranty with every purchase. Our collection features some of the
              most exquisite pre-owned jewellery and luxury watches available worldwide.</p>
            <button class="common-primary-btn">Book Now</button>
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
                      <img src="./assets/image/inspire-1.png" alt="Featured Property" />
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
                      <img src="./assets/image/gallary.jpg" alt="Featured Property" />
                    </div>

                  </a>
                </div>
                <div class="property-item">
                  <a href="#">
                    <div class="property-img">
                      <img src="./assets/image/terms.jpg" alt="Featured Property" />
                    </div>

                  </a>
                </div>
                <div class="property-item">
                  <a href="#">
                    <div class="property-img">
                      <img src="./assets/image/luxury-jewellery-display.jpg" alt="Featured Property" />
                    </div>

                  </a>
                </div>

              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <section class="contact-us-section">
      <div class="container">
        <div class="row">
          <h4 class="common-title">Get Started. Lock in a price now.</h4>
        </div>
        <div class="contact-main-box">
          <div class="row">
            <div class="col-md-4 col-12">
              <div class="contact-box slider-down-load">
                <a href="mailto:sjl123@gmail.com">
                  <div class="icon-box">
                    <i class="fa-solid fa-envelope"></i>
                  </div>
                </a>
                <h6>Click</h6>
                <div class="link-box"><a href="mailto:sjl123@gmail.com">sjl123@gmail.com</a></div>
              </div>
            </div>
            <div class="col-md-4 col-12">
              <div class="contact-box slider-down-load">
                <a href="tel:+42 (0) 227 271 1232">
                  <div class="icon-box">
                    <i class="fa-solid fa-phone"></i>
                  </div>
                </a>
                <h6>Call</h6>
                <div class="link-box"><a href="tel:+42 (0) 227 271 1232">+42 (0) 227 271 1232</a></div>
              </div>
            </div>
            <div class="col-md-4 col-12">
              <div class="contact-box slider-down-load ">
                <a href="tel:+42 (0) 227 271 1232">
                  <div class="icon-box">
                    <i class="fa-solid fa-location-dot"></i>
                  </div>
                </a>
                <h6>Visit</h6>
                <div class="link-box">Akshya Nagar 1st Block 1st Cross, Rammurthy nagar, Bangalore-560016
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>
  @endsection
