@php
  $sid = session()->getId();
  $cartCount = \App\Models\Cart::where('session_id',$sid)->where('status','open')->withCount('items')->first()->items_count ?? 0;
  $favoritedIdCount = \App\Models\Favorite::where('user_id', auth()->id())
  ->pluck('external_id')
  ->count();

@endphp

    <div class="header-part">
      <header class="custom-header desktop-view-header">
        <!-- top header -->
        <div class="top-header">
          <div class="container">
            <div class="row">
              <div class="col-xl-6 col-lg-8 col-md-6 col-12">
                <x-price-ticker />
              </div>
              <div class="col-xl-6 col-lg-4 col-md-6 col-12">
                <div class="marquee">
                  <div class="track">
                    <div class="content">
                      <x-price-ticker-slide />
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- bottom header -->
        <div class="bottom-header">
          <div class="container">
            <nav class="navbar navbar-expand-lg" style="padding: 0px;">
              <div class="navbar-logo-bug">
                <a class="navbar-brand logo-defulat" href="/">
                  <img src="{{ asset('./assets/image/logo-dark.svg') }}">
                </a>
                <a class="navbar-brand logo-scroll" href="/">
                  <img src="{{ asset('./assets/image/logo-scroll.svg') }}">
                </a>
                <div class="mobile-view-socil-menu">
                  <ul class="socil-menu">
                    <li class="header-contact">
                      <a href="tel:+42 7930927551">
                        <sapn>
                          <i class="fa-solid fa-phone"></i>
                        </sapn>
                        <span>
                          +44 0000000000</span>
                      </a>
                    </li>
                    <li>
                      <a href="#" class="nav-link searchToggle"><i
                          class="fa-solid fa-magnifying-glass"></i></a>
                    </li>
                    <li>
                      <a href="login.html" class="nav-link"><i
                          class="fa-regular fa-user"></i></a>
                    </li>
                    <li>
                      <a href="cart-listing.html" class="nav-link"><i
                          class="fa-solid fa-basket-shopping"></i></a>
                      <div class="cart-item-box"><span>1</span></div>
                    </li>
                  </ul>
                </div>
                <button class="navbar-toggler" type="button"
                  data-bs-toggle="collapse"
                  data-bs-target="#navbarExampleOnHover"
                  aria-controls="navbarExampleOnHover" aria-expanded="false"
                  aria-label="Toggle navigation">
                  <span class="navbar-toggler-icon"></span>
                </button>
              </div>

              <div class="collapse navbar-collapse" id="navbarExampleOnHover">
                <ul class="navbar-nav me-auto ps-lg-0"
                  style="padding-left: 0.15rem">
                  <li class="nav-item dropdown dropdown-hover position-static">
                    <a data-mdb-dropdown-init class="nav-link dropdown-toggle"
                      href="#" id="navbarDropdown" role="button"
                      data-mdb-toggle="dropdown" aria-expanded="false">
                      Buy
                    </a>
                    <!-- Dropdown menu -->
                    <div class="dropdown-menu w-100 mt-0"
                      aria-labelledby="navbarDropdown"
                      style="border-top-left-radius: 0;
                            border-top-right-radius: 0;
                          ">

                      <div class="container">
                        <div class="row my-4">
                          <div class="col-md-6 col-lg-2 mb-3 mb-lg-0">
                            <h6 class="common-megamenu-title">
                              Explicabo voluptas
                            </h6>
                            <div class="list-group list-group-flush">
                              <a href="product-listing.html"
                                class="list-group-item list-group-item-action">Gold
                                Coins</a>
                              <a href="product-listing.html"
                                class="list-group-item list-group-item-action">Silver
                                Bars</a>
                              <a href="product-listing.html"
                                class="list-group-item list-group-item-action">Silver
                                Coins</a>
                              <a href="product-listing.html"
                                class="list-group-item list-group-item-action">Platinum
                                Bars</a>
                              <a href="product-listing.html"
                                class="list-group-item list-group-item-action">Accessories</a>
                              <a href="product-listing.html"
                                class="list-group-item list-group-item-action">Accessories</a>
                              <a href="product-listing.html"
                                class="list-group-item list-group-item-action">Clearance</a>
                            </div>
                          </div>
                          <div class="col-md-6 col-lg-2 mb-3 mb-lg-0">
                            <h6 class="common-megamenu-title">
                              Explicabo voluptas
                            </h6>
                            <div class="list-group list-group-flush">
                              <a href="product-listing.html"
                                class="list-group-item list-group-item-action">Explicabo
                                voluptas</a>
                              <a href="product-listing.html"
                                class="list-group-item list-group-item-action">Perspiciatis
                                quo</a>
                              <a href="product-listing.html"
                                class="list-group-item list-group-item-action">Cras
                                justo
                                odio</a>
                              <a href="product-listing.html"
                                class="list-group-item list-group-item-action">Laudantium
                                maiores</a>
                              <a href="product-listing.html"
                                class="list-group-item list-group-item-action">Provident
                                dolor</a>
                            </div>
                          </div>
                          <div class="col-md-6 col-lg-2 mb-3 mb-md-0">
                            <h6 class="common-megamenu-title">
                              Explicabo voluptas
                            </h6>
                            <div class="list-group list-group-flush">
                              <a href="product-listing.html"
                                class="list-group-item list-group-item-action">Iste
                                quaerato</a>
                              <a href="product-listing.html"
                                class="list-group-item list-group-item-action">Cras
                                justo odio</a>
                              <a href="product-listing.html"
                                class="list-group-item list-group-item-action">Est
                                iure</a>
                              <a href="product-listing.html"
                                class="list-group-item list-group-item-action">Praesentium</a>
                              <a href="product-listing.html"
                                class="list-group-item list-group-item-action">Laboriosam</a>
                            </div>
                          </div>
                          <div class="col-md-6 col-lg-6">

                            <div class="list-group list-group-flush">
                              <div class="header-content-box">
                                <div>
                                  <a href
                                    class="list-group-item list-group-item-action">
                                    <div class="list-group list-group-flush">
                                      <div class="header-img">
                                        <img
                                          src="{{ asset('./assets/image/about-card-2.png') }}">
                                      </div>
                                    </div>
                                  </a>
                                </div>
                                <div class="header-content">
                                  <h6>Featured</h6>
                                  <h5 class="common-title">Membership
                                    Levels</h5>
                                  <p>Collect points for sales and purchases and
                                    unlock rewards by registering today</p>
                                  <button
                                    class="common-primary-btn">Discover</button>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </li>
                  <li class="nav-item dropdown dropdown-hover position-static">
                    <a data-mdb-dropdown-init class="nav-link dropdown-toggle"
                      href="#" id="navbarDropdown" role="button"
                      data-mdb-toggle="dropdown" aria-expanded="false">
                      Sell
                    </a>
                    <!-- Dropdown menu -->
                    <div class="dropdown-menu w-100 mt-0"
                      aria-labelledby="navbarDropdown"
                      style="border-top-left-radius: 0;
                            border-top-right-radius: 0;
                          ">

                      <div class="container">
                        <div class="row my-4">
                          <div class="col-md-6 col-lg-2 mb-3 mb-lg-0">
                            <h6 class="common-megamenu-title">
                              Explicabo voluptas
                            </h6>
                            <div class="list-group list-group-flush">
                              <a href="product-listing.html"
                                class="list-group-item list-group-item-action">Sell
                                Gold</a>
                              <a href="product-listing.html"
                                class="list-group-item list-group-item-action">Sell
                                Silver</a>
                              <a href="product-listing.html"
                                class="list-group-item list-group-item-action">Sell
                                Platinum</a>
                              <a href="product-listing.html"
                                class="list-group-item list-group-item-action">Sell
                                Palladium</a>
                            </div>
                          </div>
                          <div class="col-md-6 col-lg-2 mb-3 mb-lg-0">
                            <h6 class="common-megamenu-title">
                              Explicabo voluptas
                            </h6>
                            <div class="list-group list-group-flush">
                              <a href="product-listing.html"
                                class="list-group-item list-group-item-action">Explicabo
                                voluptas</a>
                              <a href="product-listing.html"
                                class="list-group-item list-group-item-action">Perspiciatis
                                quo</a>
                              <a href="product-listing.html"
                                class="list-group-item list-group-item-action">Cras
                                justo odio</a>
                              <a href="product-listing.html"
                                class="list-group-item list-group-item-action">Laudantium
                                maiores</a>
                              <a href="product-listing.html"
                                class="list-group-item list-group-item-action">Provident
                                dolor</a>
                            </div>
                          </div>
                          <div class="col-md-6 col-lg-2 mb-3 mb-lg-0">
                            <h6 class="common-megamenu-title">
                              Explicabo voluptas
                            </h6>
                            <div class="list-group list-group-flush">
                              <a href
                                class="list-group-item list-group-item-action">Explicabo
                                voluptas</a>
                              <a href
                                class="list-group-item list-group-item-action">Perspiciatis
                                quo</a>
                              <a href
                                class="list-group-item list-group-item-action">Cras
                                justo odio</a>
                              <a href
                                class="list-group-item list-group-item-action">Laudantium
                                maiores</a>
                              <a href
                                class="list-group-item list-group-item-action">Provident
                                dolor</a>
                            </div>
                          </div>
                          <div class="col-md-6 col-lg-2 mb-3 mb-md-0">
                            <div class="list-group list-group-flush">
                              <div class="header-content-box">
                                <div>
                                  <a href
                                    class="list-group-item list-group-item-action">
                                    <div class="list-group list-group-flush">
                                      <div class="header-img">
                                        <img
                                          src="{{ asset('./assets/image/about-card-2.png') }}">
                                      </div>
                                    </div>
                                  </a>
                                </div>
                                <div class="header-content">
                                  <h6>Featured</h6>
                                  <h5 class="common-title">Membership
                                    Levels</h5>
                                  <p>Collect points for sales and purchases and
                                    unlock rewards by registering today</p>
                                  <button
                                    class="common-primary-btn">Discover</button>
                                </div>
                              </div>
                            </div>
                          </div>

                        </div>
                      </div>
                    </div>
                  </li>
                  <li class="nav-item">
                    <a href="{{url('preowned')}}" class="nav-link">Preowned
                      Items </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{url('diamond')}}" class="nav-link">Diamond Items
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{url('about-us')}}" class="nav-link">About Us
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{url('contact')}}" class="nav-link">Contact us
                    </a>
                  </li>
                  <li class="header-contact mobile-contact">
                    <a href="tel:+42 7930927551">
                      <sapn>
                        <i class="fa-solid fa-phone"></i>
                      </sapn>
                      <span>
                        +44 0000000000</span>
                    </a>
                  </li>
                </ul>

                <ul class="socil-menu desk-view-socil-menu">
                  <li class="header-contact">
                    <a href="tel:+42 7930927551">
                      <sapn>
                        <i class="fa-solid fa-phone"></i>
                      </sapn>
                      <span>
                        +44 0000000000</span>
                    </a>
                  </li>
                  <li>
                    <a href="#" class="nav-link searchToggle"><i
                        class="fa-solid fa-magnifying-glass"></i></a>
                  </li>
                  @auth
                      {{-- If user is logged in --}}
                      <li>
                          <a href="{{ route('dashboard') }}" class="nav-link">
                              <i class="fa-regular fa-user"></i>
                          </a>
                      </li>
                      <li>
                          <a href="{{ url('/wishlist') }}" class="nav-link">
                              <i class="fa-regular fa-heart"></i>
                          </a>
                          <div class="heart-item-box"><span>{{$favoritedIdCount}}</span></div>
                      </li>
                      <li>
                          <a href="{{ url('/cart') }}" class="nav-link">
                              <i class="fa-solid fa-basket-shopping"></i>
                          </a>
                          <div class="cart-item-box"><span>{{ $cartCount }}</span></div>
                      </li>
                      
                  @else
                      {{-- If user is NOT logged in --}}
                      <li>
                          <a href="{{ route('login') }}" class="nav-link">
                              <i class="fa-regular fa-user"></i>
                          </a>
                      </li>
                      <li>
                        <a href="{{ url('/cart') }}" class="nav-link">
                            <i class="fa-solid fa-basket-shopping"></i>
                        </a>
                        <div class="cart-item-box"><span>{{ $cartCount }}</span></div>
                      </li>
                  @endauth
                </ul>
              </div>
            </nav>
            <div class="d-flex gap-2 align-items-center searchBar d-none">
              <input type="text" id="searchInputDesk"
                class="form-control ui-autocomplete-input"
                placeholder="Search..."
                autocomplete="off">
              <button id="closeSearch" class="btn btn-close"
                aria-label="Close search"></button>
            </div>
          </div>
        </div>
      </header>
    </div>