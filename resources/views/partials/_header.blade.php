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
                          +44 7477 068003</span>
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
                          <a href="{{ route('login') }}" class="nav-link"><i
                              class="fa-regular fa-user"></i></a>
                        </li>
                        <li>
                          <a href="{{ url('/cart') }}" class="nav-link"><i
                              class="fa-solid fa-basket-shopping"></i></a>
                          <div class="cart-item-box"><span>{{ $cartCount }}</span></div>
                        </li>
                    @endauth
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
                              Categories
                            </h6>
                            
                            <?php 
                            $svc = app(\App\Services\ExternalProductsService::class);
                            $pricing = app(\App\Services\PricingService::class);

                            $cats = getCategories($svc, $pricing,'header');
                            ?>
                            @php
                              // $cats is coming from your helper: $cats = getCategories($svc, $pricing);
                              $cats = is_array($cats) ? $cats : [];

                              // Current selected categories from query (for "active" state)
                              $currentCats = collect((array) request()->query('category_slug', []))
                                  ->map(fn($s) => (string) $s)
                                  ->all();
                          @endphp

                          <div class="list-group list-group-flush">
                            @foreach ($cats as $cat)
                              @php
                                  $slug   = $cat['slug'] ?? null;
                                  $name   = $cat['name'] ?? '—';
                                  $count  = $cat['count'] ?? null;

                                  // Build URL: keep current query and set category_slug[] to this one
                                  $qs = array_merge(request()->query(), ['category' => 'bullion','category_slug' => $slug ? [$slug] : []]);
                                  $url = $slug ? route('ext.catalog', $qs) : '#';

                                  $isActive = $slug && in_array($slug, $currentCats, true);
                              @endphp

                              <a href="{{ $url }}"
                                 class="list-group-item list-group-item-action {{ $isActive ? 'active' : '' }}">
                                {{ $name }}
                              </a>
                            @endforeach
                          </div>

                          </div>
                          <div class="col-md-6 col-lg-2 mb-3 mb-lg-0">
                            <h6 class="common-megamenu-title">
                              By Weight
                            </h6>
                            @php
                                $gwo = getWeughtOption($svc, $pricing);
                                $weights   = is_array($gwo) ? $gwo : [];
                                $selected  = collect((array) request()->query('weight_option_slug', []))
                                               ->map(fn($v) => (string) $v)->all();
                            @endphp
                            <div class="list-group list-group-flush">
                              @forelse ($weights as $w)
                                  @php
                                    $slug  = $w['slug'] ?? null;
                                    $label = $w['label'] ?? (($w['grams_exact'] ?? '').' g');
                                    $count = $w['count'] ?? null;

                                    $qs = array_merge(request()->query(), ['category' => 'bullion','weight_option_slug' => $slug ? [$slug] : []]);
                                    $url = $slug ? route('ext.catalog', $qs) : '#';

                                    $isActive = $slug && in_array($slug, $selected, true);
                                  @endphp

                                  <a href="{{ $url }}"
                                     class="list-group-item list-group-item-action {{ $isActive ? 'active' : '' }}">
                                    {{ $label }}
                                  
                                  </a>
                                @empty
                                  <span class="list-group-item text-muted">No weights available</span>
                                @endforelse
                            
                            </div>
                          </div>
                          <div class="col-md-6 col-lg-2 mb-3 mb-md-0">
                            <h6 class="common-megamenu-title">
                              Collections
                            </h6>
                            <div class="list-group list-group-flush">
                             @php
                              $brands = is_array(getBrand($svc, $pricing)) ? getBrand($svc, $pricing) : [];

                              // Read currently-selected brands from the query string
                              $selectedBrands = collect((array) request()->query('brand_slug', []))
                                  ->map(fn($v) => (string) $v)
                                  ->all();
                          @endphp

                            <div class="list-group list-group-flush">
                              @forelse ($brands as $b)
                                @php
                                    $slug  = $b['slug'] ?? null;              // e.g. "gold-company"
                                    $name  = $b['name'] ?? '—';
                                    $count = $b['count'] ?? null;

                                    // Build URL: keep all current filters; set brand_slug[] to this brand
                                    $qs  = array_merge(request()->query(), ['category' => 'bullion','brand_slug' => $slug ? [$slug] : []]);
                                    $url = $slug ? route('ext.catalog', $qs) : '#';

                                    $isActive = $slug && in_array($slug, $selectedBrands, true);
                                @endphp

                                <a href="{{ $url }}"
                                   class="list-group-item list-group-item-action {{ $isActive ? 'active' : '' }}">
                                  {{ $name }}
                                
                                </a>
                              @empty
                                <span class="list-group-item text-muted">No brands available</span>
                              @endforelse
                            </div>

                            </div>
                          </div>
                          <div class="col-md-6 col-lg-6">

                            <div class="list-group list-group-flush">
                              <div class="header-content-box">
                                <div>
                                  <a href="{{ route('ext.catalog', ['category' => 'bullion']) }}"
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
                                    <h6>Bullion Deals</h6>
                                    <h5 class="common-title">Buy Gold at Live Market Rates</h5>
                                    <p>Get the cheapest market-linked prices on bars & coins. Transparent premiums, real-time updates, no hidden fees.</p>

                                    {{-- Use query params: /bullion?category_slug[]=gold-bars --}}
                                    <a href="{{ route('ext.catalog', ['category' => 'bullion']) }}" aria-label="Shop gold bars at live market rates">
                                       <button
                                    class="common-primary-btn">
                                      Buy Now
                                    </button>
                                    </a>
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
                              Sell By Category
                            </h6>
                            <div class="list-group list-group-flush">
                              <a href="{{ route('sellgold.index') }}"
                                class="list-group-item list-group-item-action">Sell
                                Gold</a>
                              <a href="{{ route('sellsilver.index') }}"
                                class="list-group-item list-group-item-action">Sell
                                Silver</a>
                              <a href="{{ route('sellplatinum.index') }}"
                                class="list-group-item list-group-item-action">Sell
                                Platinum</a>
                              <a href="{{route('sellpalladium.index')}}"
                                class="list-group-item list-group-item-action">Sell
                                Palladium</a>
                            </div>
                          </div>
                         @php
                            // Fetch brands (array like: [['id'=>..,'name'=>'Gold Company','slug'=>'gold-company','count'=>0], ...])
                            $brands = is_array(getBrand($svc, $pricing)) ? getBrand($svc, $pricing) : [];

                            // Currently-selected brand slugs from the query string
                            $selectedBrands = collect((array) request()->query('brand_slug', []))
                                ->map(fn($v) => (string) $v)
                                ->all();
                        @endphp

                        <div class="col-md-6 col-lg-2 mb-3 mb-lg-0">
                          <h6 class="common-megamenu-title">Sell Gold by Brand</h6>

                          <div class="list-group list-group-flush">
                            @forelse ($brands as $b)
                              @php
                                $slug  = $b['slug'] ?? null;
                                $name  = $b['name'] ?? '—';
                                $count = $b['count'] ?? null;

                                // Keep current filters, set/replace brand_slug[] with this brand
                                $qs  = array_merge(request()->query(), ['category' => 'bullion','brand_slug' => $slug ? [$slug] : []]);
                                $url = $slug ? route('ext.catalog', $qs) : '#';

                                $isActive = $slug && in_array($slug, $selectedBrands, true);
                              @endphp

                              <a href="{{route('sell.index')}}"
                                 class="list-group-item list-group-item-action {{ $isActive ? 'active' : '' }}">
                                {{ $name }}
                              
                              </a>
                            @empty
                              <span class="list-group-item text-muted">No brands available</span>
                            @endforelse
                          </div>
                        </div>

                       @php
                        // Get weights (array like: [{id, grams_exact, label, slug, count}, ...])
                        $weights = is_array($gwo ?? null) ? $gwo : (is_array(getWeughtOption($svc, $pricing)) ? getWeughtOption($svc, $pricing) : []);

                        // Currently selected weights from query (for active state in Buy menu)
                        $selectedWeights = collect((array) request()->query('weight_option_slug', []))
                            ->map(fn($v) => (string) $v)->all();

                        // Sell route helper (fallback to /sell if named route missing)
                        $sellRouteExists = \Illuminate\Support\Facades\Route::has('sell.index');
                      @endphp
                      <div class="col-md-6 col-lg-2 mb-3 mb-lg-0">
                        <h6 class="common-megamenu-title">Sell by Weight</h6>
                        <div class="list-group list-group-flush">
                          @forelse ($weights as $w)
                            @php
                              $slug  = $w['slug'] ?? null;
                              $label = $w['label'] ?? (($w['grams_exact'] ?? '').' g');

                              // SELL: send weight as query to your sell flow (adjust param name if needed)
                              $sellParams = $slug ? ['weight_option_slug' => [$slug]] : [];
                              $sellUrl    = $sellRouteExists
                                              ? route('sell.index', $sellParams)
                                              : url('/sell').($slug ? ('?'.http_build_query($sellParams)) : '');
                            @endphp

                            <a href="{{ $sellUrl }}" class="list-group-item list-group-item-action">
                              {{ $label }}
                            </a>
                          @empty
                            <span class="list-group-item text-muted">No weight options</span>
                          @endforelse
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
                                <h6>Sell With Confidence</h6>
                                <h5 class="common-title">Sell Your Gold, Jewellery</h5>
                                <p>Free instant valuation at live market rates. No fees, no pressure — same-day bank transfer.</p>
                                 <a href="{{ url('sell-now') }}" aria-label="Shop gold bars at live market rates">
                                       <button
                                    class="common-primary-btn">
                                      Sell Now
                                    </button>
                                    </a>
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
                    <a href="tel:+44 7477068003">
                      <sapn>
                        <i class="fa-solid fa-phone"></i>
                      </sapn>
                      <span>
                        +44  7477 068003</span>
                    </a>
                  </li>
                </ul>

                <ul class="socil-menu desk-view-socil-menu">
                  <li class="header-contact">
                    <a href="tel:+44 7477068003">
                      <sapn>
                        <i class="fa-solid fa-phone"></i>
                      </sapn>
                      <span>
                        +44  7477 068003</span>
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