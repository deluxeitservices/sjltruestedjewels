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
            <div class="link-box"><a
                href="mailto:shivanijewellers.uk@gmail.com">shivanijewellers.uk@gmail.com</a></div>
          </div>
        </div>
        <div class="col-md-4 col-12">
          <div class="contact-box slider-down-load">
            <a href="tel:+44 7477 068003">
              <div class="icon-box">
                <i class="fa-solid fa-phone"></i>
              </div>
            </a>
            <h6>Call</h6>
            <div class="link-box"><a href="tel:+44 7477 068003">+44 7477 068003</a>
            </div>
          </div>
        </div>
        <div class="col-md-4 col-12">
          <div class="contact-box slider-down-load ">
            <a href="tel:+44 7477 068003">
              <div class="icon-box">
                <i class="fa-solid fa-location-dot"></i>
              </div>
            </a>
            <h6>Visit</h6>
            <div class="link-box">Unit 2,281 Green Street(on Shafresbury Road Side) London, E7 8PD
            </div>
          </div>
        </div>
      </div>
      </a>
     
  </div>

  </div>
  </div>
  </div>
</section>
<button id="backToTop" class="back-to-top">
  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20"
    height="20" fill="none" stroke="white" stroke-width="2"
    stroke-linecap="round" stroke-linejoin="round">
    <polyline points="18 15 12 9 6 15"></polyline>
  </svg>
</button>
<!-- footer -->
<footer class="footer pt-5">
  <div class="desktop-view-footer">
    <div class="container">
      <div class="row gy-4">

        <!-- Logo & About -->
        <div class="col-lg-3 col-md-6 col-12">
          <a href="index.html">
            <img src="{{ asset('./assets/image/logo-scroll.svg') }}" class="footer-logo">
            <!-- <img src="./assets/image/footer-logo.svg" class="footer-logo"> -->
          </a>
          <p>We provide the best solutions to help you grow your business
            and achieve your goals.</p>
          <ul class="social-media">
            <li><a href="#" class=" text-decoration-none"><i
                  class="fa-brands fa-facebook"></i></a></li>
            <li><a href="#" class="text-decoration-none"><i
                  class="fa-brands fa-instagram"></i></a></li>
            <li><a href="#" class=" text-decoration-none"><i
                  class="fa-brands fa-whatsapp"></i></a></li>
          </ul>
        </div>


        <!-- Links -->
        <div class="col-lg-2 col-md-6 col-12">
          <h6>Buying</h6>
          <ul class="list-unstyled">
            <li><a href="{{ route('ext.catalog', ['category' => 'bullion','category_slug' =>'gold-bars']) }}" class=" text-decoration-none">Shop Gold</a></li>
            <li><a href="{{ route('ext.catalog', ['category' => 'bullion','category_slug' =>'silver-bars']) }}" class="text-decoration-none d-block ">Shop
                Silver</a></li>
            <li><a href="{{route('vatfree.index')}}" class="text-decoration-none d-block">VAT
                Free</a></li>
          </ul>
        </div>

        <!-- Services -->
        <div class="col-lg-2 col-md-6 col-12">
          <h6>Selling</h6>
          <ul class="list-unstyled">
            <li> <a href="{{ route('sellgold.index') }}"
                class="text-decoration-none d-block">Sell
                Gold</a>
            </li>
            <li>
              <a href="{{ route('sellsilver.index') }}"
                class="text-decoration-none d-block">Sell
                Silver</a>
            </li>
            <li>
              <a href="{{ route('sellplatinum.index') }}"
                class="text-decoration-none d-block">Sell
                Platinum</a>
            </li>
            <li>
              <a href="{{route('sellpalladium.index')}}"
                class="text-decoration-none d-block">Sell
                Palladium</a>
            </li>
          </ul>
        </div>

        <!-- Contact & Social -->
        <div class="col-lg-2 col-md-6 col-12">
          <h6>About Us</h6>
          <ul class="list-unstyled">
            <li>
              <a href="{{route('ourshowroom.index')}}"
                class="text-decoration-none d-block ">Our Showroom</a>
            </li>
            <li>
              <a href="{{route('guidetobuying.index')}}"
                class="text-decoration-none d-block ">Guide To Buying</a>
            </li>
            <li>
              <a href="{{route('blog')}}"
                class="text-decoration-none d-block ">Blog</a>
            </li>

            <li>
              <a href="{{route('shippingdelivery.index')}}"
                class="text-decoration-none d-block ">Shipping Delivery</a>
            </li>
            <li>
              <a href="{{route('privacypolicy.index')}}"
                class="text-decoration-none d-block ">Privacy
                Policy
              </a>
            </li>
            <li>
              <a href="{{route('termsandconditions.index')}}"
                class="text-decoration-none d-block ">Terms and
                Conditions</a>
            </li>
            <li>
              <a href="{{route('returnsexchanges.index')}}"
                class="text-decoration-none d-block ">Returns
                Exchanges</a>
            </li>
          </ul>
        </div>
        <div class="col-lg-3 col-md-6 col-12">
          <div class="subscribe-section">
            <h6>Join Us!</h6>
            <p>Subscribe to our weekly newsletter for skincare tips and
              updates.</p>
            <form id="newsletterForm" class="d-flex flex-sm-row subscribe-div newsletter-form" novalidate>

              @csrf
              <input id="newsletterEmail" name="email" type="email" class="form-control mr-sm-2 mb-sm-0"
                placeholder="Your Email" required />
              <button class="btn" type="submit" id="newsletterBtn">Subscribe</button>
            </form>
            <div  class="newsletter-msg mt-2" style="display:none;"></div>

          </div>
          <div class="contact-info">
            <h6>Visit Us</h6>
            <ul class>
              <li>
                <a href="mailto:shivanijewellers.uk@gmail.com"><i class="fa-regular fa-envelope"></i>
                  shivanijewellers.uk@gmail.com</a>
              </li>
              <li>
                <a href="tel:+44 7477068003"><i class="fa-solid fa-phone"></i> +44 7477 068003</a>
              </li>
            </ul>
          </div>
        </div>
      </div>
      <div class="row border-top pt-3 mt-4 pb-3">
        <div class="col-md-6">
          <div class="text-left">
            <small class="footer-bottom-text">© <?php echo date('Y'); ?> SJL Trusted Jewels. All
              Rights
              Reserved.</small>
          </div>
        </div>
        <div class="col-md-6">
          <div class="devlop-link">
            <a href="https://deluxe-it-services.co.uk/" target="_blank">Develop by Deluxe IT Services</a>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="mobile-view-footer">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <a href="index.html">
            <img src="./assets/image/fooer-logo.svg" class="footer-logo">
          </a>
          <p>We provide the best solutions to help you grow your business
            and achieve your goals.</p>
          <ul class="social-media">
            <li><a href="#" class=" text-decoration-none"><i
                  class="fa-brands fa-facebook"></i></a></li>
            <li><a href="#" class="text-decoration-none"><i
                  class="fa-brands fa-instagram"></i></a></li>
            <li><a href="#" class=" text-decoration-none"><i
                  class="fa-brands fa-whatsapp"></i></a></li>
          </ul>
        </div>
        <div class="col-12">

          <div class="accordion" id="accordionExample">
            <div class="accordion-item">
              <h2 class="accordion-header" id="headingOne">
                <button data-mdb-collapse-init
                  class="accordion-button collapsed" type="button"
                  data-mdb-toggle="collapse"
                  data-mdb-target="#collapseOne" aria-expanded="true"
                  aria-controls="collapseOne">
                  Buying
                </button>
              </h2>
              <div id="collapseOne" class="accordion-collapse collapse"
                aria-labelledby="headingOne"
                data-mdb-parent="#accordionExample">
                <div class="accordion-body">
                  <ul class="list-unstyled">
                    <li><a href="{{ route('ext.catalog', ['category' => 'bullion','category_slug' =>'gold-bars']) }}" class=" text-decoration-none">Shop Gold</a></li>
                    <li><a href="{{ route('ext.catalog', ['category' => 'bullion','category_slug' =>'silver-bars']) }}" class="text-decoration-none d-block ">Shop
                        Silver</a></li>
                    <li><a href="{{route('vatfree.index')}}" class="text-decoration-none d-block">VAT
                        Free</a></li>
                  </ul>
                </div>
              </div>
            </div>
            <div class="accordion-item">
              <h2 class="accordion-header" id="headingTwo">
                <button data-mdb-collapse-init
                  class="accordion-button collapsed" type="button"
                  data-mdb-toggle="collapse" data-mdb-target="#collapseTwo"
                  aria-expanded="false"
                  aria-controls="collapseTwo">
                  Selling
                </button>
              </h2>
              <div id="collapseTwo" class="accordion-collapse collapse"
                aria-labelledby="headingTwo"
                data-mdb-parent="#accordionExample">
                <div class="accordion-body">
                  <ul class="list-unstyled">
                    <li> <a href="{{ route('sellgold.index') }}"
                        class="text-decoration-none d-block">Sell
                        Gold</a>
                    </li>
                    <li>
                      <a href="{{ route('sellsilver.index') }}"
                        class="text-decoration-none d-block">Sell
                        Silver</a>
                    </li>
                    <li>
                      <a href="{{ route('sellplatinum.index') }}"
                        class="text-decoration-none d-block">Sell
                        Platinum</a>
                    </li>
                    <li>
                      <a href="{{route('sellpalladium.index')}}"
                        class="text-decoration-none d-block">Sell
                        Palladium</a>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
            <div class="accordion-item">
              <h2 class="accordion-header" id="headingThree">
                <button data-mdb-collapse-init
                  class="accordion-button collapsed" type="button"
                  data-mdb-toggle="collapse"
                  data-mdb-target="#collapseThree" aria-expanded="false"
                  aria-controls="collapseThree">
                  About Us
                </button>
              </h2>
              <div id="collapseThree" class="accordion-collapse collapse"
                aria-labelledby="headingThree"
                data-mdb-parent="#accordionExample">
                <div class="accordion-body">
                  <ul class="list-unstyled">

                    <li>
                      <a href="{{route('ourshowroom.index')}}"
                        class="text-decoration-none d-block ">Our Showroom</a>
                    </li>
                    <li>
                      <a href="{{route('guidetobuying.index')}}"
                        class="text-decoration-none d-block ">Guide To Buying</a>
                    </li>
                    <li>
                      <a href="blog.html"
                        class="text-decoration-none d-block ">Blog</a>
                    </li>

                    <li>
                      <a href="{{route('shippingdelivery.index')}}"
                        class="text-decoration-none d-block ">Shipping Delivery</a>
                    </li>
                    <li>
                      <a href="{{route('privacypolicy.index')}}"
                        class="text-decoration-none d-block ">Privacy
                        Policy
                      </a>
                    </li>
                    <li>
                      <a href="{{route('termsandconditions.index')}}"
                        class="text-decoration-none d-block ">Terms and
                        Conditions</a>
                    </li>
                    <li>
                      <a href="{{route('returnsexchanges.index')}}"
                        class="text-decoration-none d-block ">Returns
                        Exchanges</a>
                    </li>

                  </ul>
                </div>
              </div>
            </div>
            <div class="accordion-item">
              <h2 class="accordion-header" id="headingfour">
                <button data-mdb-collapse-init
                  class="accordion-button collapsed" type="button"
                  data-mdb-toggle="collapse" data-mdb-target="#collapsefour"
                  aria-expanded="false"
                  aria-controls="collapsefour">
                  Join Us !
                </button>
              </h2>
              <div id="collapsefour" class="accordion-collapse collapse"
                aria-labelledby="headingfour"
                data-mdb-parent="#accordionExample">
                <div class="accordion-body">
                  <p>Subscribe to our weekly newsletter for skincare tips
                    and updates.</p>
                  <form id="newsletterForm" class="d-flex flex-sm-row subscribe-div newsletter-form" novalidate>
                    @csrf
                    <input id="newsletterEmail"  name="email" type="email" class="form-control mr-sm-2 mb-sm-0"
                      placeholder="Your Email" />
                    <button class="btn" type="submit" id="newsletterBtn">Subscribe</button>
                  </form>
                  <div  class="newsletter-msg mt-2" style="display:none;"></div>

                </div>
              </div>
            </div>
            <div class="accordion-item">
              <h2 class="accordion-header" id="headingfive">
                <button data-mdb-collapse-init
                  class="accordion-button collapsed" type="button"
                  data-mdb-toggle="collapse" data-mdb-target="#collapsefive"
                  aria-expanded="false"
                  aria-controls="collapsefive">
                  Visit Us
                </button>
              </h2>
              <div id="collapsefive" class="accordion-collapse collapse"
                aria-labelledby="headingfive"
                data-mdb-parent="#accordionExample">
                <div class="accordion-body">
                  <ul class="visit-us">
                    <li>
                      <a href="mailto:shivanijewellers.uk@gmail.com"><i class="fa-regular fa-envelope"></i>
                  shivanijewellers.uk@gmail.com</a>
                    </li>
                    <li>
                      <a href="tel:+44 7477068003"><i class="fa-solid fa-phone"></i> +44 7477 068003</a>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>
      <div class="row border-top pt-3 mt-4 pb-3">
        <div class="col-md-6">
          <div class="text-left">
            <small class="footer-bottom-text">© <?php echo date('Y'); ?> SJL Trusted Jewels. All
              Rights
              Reserved.</small>
          </div>
        </div>
      </div>
    </div>

  </div>
  <!-- <div class="row border-top pt-3 mt-4 pb-3">
        <div class="col-md-6">
          <div class="text-left">
            <small class="footer-bottom-text">© 2025 Company Name. All
              Rights
              Reserved.</small>
          </div>
        </div>
        <div class="col-md-6">
          <div class="devlop-link">
            <a href="https://deluxe-it-services.co.uk/" target="_blank">Develop by Deluxe IT Services</a>
          </div>
        </div>
      </div> -->
  </div>
  </div>
</footer>


<!-- javascript -->
<script src="{{ URL::asset('./js/jQuery.js?t=2') }}"></script>
<script src="{{ URL::asset('./js/bootstrap.bundle.min.js?t=2') }}"></script>
<script src="{{ URL::asset('./js/popper.min.js?t=2') }}"></script>
<script src="{{ URL::asset('js/owl.carousel.js?t=2') }}"></script>
<script src="{{ URL::asset('js/owl.carousel.min.js?t=2') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.2.0/mdb.min.js?t=2') }}"></script>
<script src="https://icodefy.com/Tools/iZoom/js/Vendor/jquery/jquery-ui.min.js"></script>
<script src="https://icodefy.com/Tools/iZoom/js/Vendor/ui-carousel/ui-carousel.js">
</script>
<script src="https://codepen.io/ranz/pen/rEaJNW.js">
</script>
<script src="https://codepen.io/ranz/pen/KjwyjG.js">

</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/elevatezoom/3.0.8/jquery.elevatezoom.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.5.8/slick.min.js"></script>

<script src="{{ URL::asset('./js/home-banner.js?t=2') }}"></script>
<script src="{{ URL::asset('./js/new-arrivals.js?t=2') }}"></script>
<script src="{{ URL::asset('js/our-legency.js?t=2') }}"></script>
<script src="{{ URL::asset('js/number-count.js') }}"></script>
<script src="{{ URL::asset('js/product-detail.js') }}"></script>
<script src="{{ URL::asset('js/proudct-detail-tab.js') }}"></script>
<script src="{{ URL::asset('js/searchbar-header.js?t=2') }}"></script>
<script src="{{ URL::asset('js/header-sticky.js?t=2') }}"></script>
<script src="{{ URL::asset('js/search-bar.js?t=2') }}"></script>
<script src="{{ URL::asset('js/validation.js?t=2') }}"></script>
<script src="{{ URL::asset('js/top-scroll.js') }}"></script>
<script src="{{ URL::asset('js/profile.js') }}"></script>
<script src="{{ URL::asset('js/sell-item.js') }}"></script>
<script src="{{ URL::asset('js/faq-section.js') }}"></script>
<script src="{{ URL::asset('js/your-detail.js') }}"></script>
<script src="{{ URL::asset('js/about-us-gallary.js') }}"></script>
<script src="https://cdn.datatables.net/2.3.3/js/dataTables.js"></script>

<script>
  document.addEventListener('DOMContentLoaded', () => {
    const FORMS = document.querySelectorAll('form.newsletter-form');
    const DEFAULT_SUCCESS = 'Subscribed! We’ll be in touch soon.';
    const getToken = (form) =>
      (form.querySelector('input[name=_token]') || document.querySelector('meta[name="csrf-token"]'))?.value || '';

    FORMS.forEach(form => {
      form.addEventListener('submit', async (e) => {
        e.preventDefault();

        const emailInput = form.querySelector('input[name="email"]');
        const btn = form.querySelector('button[type="submit"]');
        const msgBox = form.nextElementSibling?.classList.contains('newsletter-msg') ?
          form.nextElementSibling :
          null;

        console.log(emailInput);
        // basic validate
        if (!emailInput || !emailInput.value.trim()) {
          show('Please enter your email.', 'error');
          return;
        }

        // btn.disabled = true;
        // btn.dataset.prev = btn.textContent;
        // btn.textContent = 'Subscribing…';
        show('', ''); // clear

        const res = await fetch('/newsletter/subscribe', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
          },
          body: JSON.stringify({
            email: emailInput.value.trim()
          })

        });

        if (res.status === 422) {
          const data = await res.json();
          const first = data?.errors ? Object.values(data.errors)[0][0] : 'Please check your email.';
          show(first, 'error');
          emailInput.focus();
        } else if (!res.ok) {
          show('Something went wrong. Please try again.', 'error');
        } else {
          const data = await res.json().catch(() => ({}));
          show(DEFAULT_SUCCESS, 'success');
          form.reset();
        }


        function show(text, type) {
          if (!msgBox) return;
          msgBox.style.display = text ? 'block' : 'none';
          msgBox.textContent = text || '';
          msgBox.classList.remove('text-success', 'text-danger');
          if (type === 'success') msgBox.classList.add('text-success');
          if (type === 'error') msgBox.classList.add('text-danger');
        }
      });
    });
  });



  document.getElementById('password-update-button').addEventListener('click', async function () {
    const msg = document.getElementById('ajax-password-message');
    msg.classList.add('d-none'); msg.classList.remove('alert-success','alert-danger');

    const body = {
        current_password: document.getElementById('current_password').value,
        password: document.getElementById('new_password').value,
        password_confirmation: document.getElementById('password_confirmation').value,
        _token: csrfToken,
    };


    try {
        const res = await fetch(updatePasswordUrl, {
            method: 'POST',
            headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
            body: new URLSearchParams(body)
        });

        if (res.ok) {
            msg.textContent = 'Password updated successfully.';
            msg.classList.remove('d-none'); msg.classList.add('alert','alert-success');
            (document.getElementById('password-form')||{}).reset?.();
        } else {
            const data = await res.json();
            let text = 'Failed to update password.';
            if (data?.errors) {
                text = Object.values(data.errors).flat().join(' ');
            } else if (data?.message) {
                text = data.message;
            }
            msg.textContent = text;
            msg.classList.remove('d-none'); msg.classList.add('alert','alert-danger');
        }
    } catch (e) {
        msg.textContent = 'Network error.';
        msg.classList.remove('d-none'); msg.classList.add('alert','alert-danger');
    }
});

</script>