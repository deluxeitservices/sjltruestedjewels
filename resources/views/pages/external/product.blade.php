@extends('layouts.app')
@section('title', $p['title'])
@section('content')
<main>
    <div class="product-details1 common-section">
      <div class="container">
        <div class="row">
          <div class="col-xl-7 col-lg-7 col-md-12">
            <div class="pdp-image-gallery-block">
              <!-- Gallery -->
              <div class="gallery_pdp_container">
                <div id="gallery_pdp">
                  <?php foreach ($p['multiimages'] as $key => $value) { ?>
                    <a href="#" data-image="{{ $value['url'] ?: asset('assets/images/logo-dark-product-final.svg') }}" data-zoom-image="{{ $value['url'] ?: asset('assets/images/logo-dark-product-final.svg') }}">
                      <img id="" src="{{ $value['url'] ?: asset('assets/images/logo-dark-product-final.svg') }}" />
                    </a>
                  <?php } ?>
                  <a href="#" data-image="./assets/image/product-2.png" data-zoom-image="./assets/image/product-2.png">
                  </a>
                  <a href="#" data-image="./assets/image/product-3.png" data-zoom-image="./assets/image/product-3.png">
                  </a>
                  <a href="#" data-image="./assets/image/product-1.png" data-zoom-image="./assets/image/product-1.png">
                  </a>
                  <a href="#" data-image="./assets/image/product-2.png" data-zoom-image="./assets/image/product-2.png">
                  </a>
                  <a href="#" data-image="./assets/image/product-3.png" data-zoom-image="./assets/image/product-3.png">
                    
                  </a>
                </div>
                <!-- Up and down button for vertical carousel -->
                <a href="#" id="ui-carousel-next" style="display: inline;"></a>
                <a href="#" id="ui-carousel-prev" style="display: inline;"></a>
              </div>
              <!-- Gallery -->

              <!-- gallery Viewer -->
              <div class="gallery-viewer">
                <img id="zoom_10" src="{{ $p['image'] ?: asset('assets/image/logo-dark-product-final.svg') }}" data-zoom-image="{{ $p['image'] ?: asset('assets/image/logo-dark-product-final.svg') }}"
                  href="{{ $p['image'] ?: asset('assets/image/logo-dark-product-final.svg') }}" />
              </div>
            </div>

          </div>
          <div class="col-xl-5 col-lg-5 col-md-12">
            <div class="product-detail-content">
              <div class="pdp_sku_info">
                <div class="left-info">
                  <div class="product_salution ribbon-update-color tax" aria-label="Tax Efficient">SJL Trusted</div>
                  <p class="mb-0 pl-0"><span>SKU</span> {{ $p['sku'] }}</p>
                  <div class="d-flex availability-like-icons">
                    <div class="pdp_info_bottom">
                      <p>
                        <span>Availability:</span>@if($p['availability'] === 'pre_order')
                                      Pre Order
                                    @elseif($p['availability'] === 'in_stock')
                                      In Stock
                                    @else
                                      Sold Out
                                    @endif
                      </p>
                    </div>
                  </div>
                </div>
                <div class="btn-group">
                    @php
                      $isFavorited = in_array($p['external_id'], $favoritedIds);
                    @endphp
                  <a class="wishlist-btn js-fav" data-external-id="{{ $p['external_id'] }}"
                            data-title="{{ e($p['title']) }}"
                            data-prefix="{{ ($category) }}"
                            data-slug="{{ e($p['slug']) }}"
                            data-sku="{{ e($p['sku'] ?? '') }}"
                             data-slug="{{ e($p['slug'] ?? '') }}"
                            data-image="{{ e($p['image'] ?? '') }}" data-toggle="tooltip" title="fav" href="#" data-original-title="Add Product to Favourites">
                    <i class="fa-heart {{ $isFavorited ? 'fa-solid is-favorited' : 'fa-regular' }}"></i>
                  </a>
                </div>
              </div>
              <h4 class="common-title">{{ $p['title'] }}</h4>
              <div class="">
                <div class="pdp_info_description_new">
                  <p>{{$p['long_desc']}}
                  </p>
                </div>
              </div>
              <div class="pdp_info_desc d-none d-lg-flex overflow-x-auto-cst overflow-y-hidden-cst small-scroll">
                <div class="pdp_info_desc_div">
                  <p>Metal</p>
                  <h6 class="whitespace-nowrap-cst">{{$p['front_metal']['name']}}</h6>
                </div>
                <div class="pdp_info_desc_div">
                  <p>Weight</p>
                  <h6>{{$p['weight_g']}} Grams </h6>
                </div>
                <div class="pdp_info_desc_div">
                  <p>Fineness</p>
                  <h6>{{$p['fineness']}}</h6>
                </div>
                <div class="pdp_info_desc_div">
                  <p>Manufacturer</p>
                  <h6>{{$p['brand']}}</h6>
                </div>
              </div>
              <div class="product-dtl">
                <div class="product-info">
                  <!-- <div class="product-name"><i class="fa-regular fa-thumbs-up"></i> Review</div> -->
                  <!-- <div class="reviews-counter">
                  <div class="star-rating">
                    <input type="radio" id="star5" name="star-rating" value="5" checked />
                    <label for="star5" title="text">5 stars</label>
                    <input type="radio" id="star4" name="star-rating" value="4" checked />
                    <label for="star4" title="text">4 stars</label>
                    <input type="radio" id="star3" name="star-rating" value="3" checked />
                    <label for="star3" title="text">3 stars</label>
                    <input type="radio" id="star2" name="star-rating" value="2" />
                    <label for="star2" title="text">2 stars</label>
                    <input type="radio" id="star1" name="star-rating" value="1" />
                    <label for="star1" title="text">1 star</label>
                  </div>
                  <span>3 Reviews</span>
                </div> -->
                </div>

                <!-- <div class="product-choose">
                <div class="row">
                <div class="col-md-6">
                  <label for="size">Size</label>
                  <select id="size" name="size" class="form-select">
                    <option>S</option>
                    <option>M</option>
                    <option>L</option>
                    <option>XL</option>
                  </select>
                </div>
                <div class="col-md-6">
                  <label for="color">Color</label>
                  <select id="color" name="color" class="form-select">
                    <option>Blue</option>
                    <option>Green</option>
                    <option>Red</option>
                  </select>
                </div>
              </div>
              </div> -->
              @if($alreadyInCart)
                  <div class="addto-cart-btn">
                        <a href="/cart" class="common-primary-btn btn">
                            <i class="fa-solid fa-cart-arrow-down"></i> View Cart
                        </a>
                  </div>                  
              @else
                <form action="{{ route('ext.cart.add', ['category' => $category]) }}" method="post" class="mt-4 flex gap-2">
                  @csrf
                  <div class="product-count">
                    <label for="size">Quantity</label>
                    <div class="value-count-box">
                    <!--  <form action="#" class="number-count-box">
                        <div class="qtyminus">-</div>
                        <input type="text" name="quantity" value="1" class="qty">
                        <div class="qtyplus">+</div>
                      </form> -->
                      <input type="hidden" name="external_id" value="{{ $p['external_id'] }}">
                      <input type="hidden" name="product_id" value="{{ $p['external_id'] }}">
                      <!-- <input type="number" name="qty" value="1" min="1" class="border px-2 w-16"> -->
                      <div class="number-count-box flex items-center border rounded overflow-hidden">
                        <div class="qtyminus cursor-pointer select-none">-</div>
                        <input type="text" name="qty" value="1" class="qty w-12 text-center border-0">
                        <div class="qtyplus cursor-pointer select-none">+</div>
                      </div>


                      <div class="price-proudct">
                        <input type="hidden" id="price-pruct" value="1296.52" placeholder="value">
                        <p class=" text-3xl font-bold">£<span id="livePrice">{{ number_format($price ?? 0,2) }}</span></p>
                      </div>
                    </div>

                  </div>

                  <div class="addto-cart-btn">
                    <!-- <a href="cart-listing.html"> -->
                    <a href="#">
                      <!-- <button class="common-primary-btn"><i class="fa-solid fa-cart-arrow-down"></i> Add To cart</button> -->
                      
                          <button class="common-primary-btn">
                              <i class="fa-solid fa-cart-arrow-down"></i> Add to cart
                          </button>

                    </a>
                  </div>
                  
                </form>
              @endif

                
                <div class="payment-product">
                  <div class="payment-card ">
                    <a href="#" class="text-decoration-none"><img src="./assets/image/mastercard.jpg" alt=""
                        class="lazyload" loading="lazy" height="30px"></a>
                    <a href="#" class="text-decoration-none"><img src="./assets/image/mestro.png" alt=""
                        class="lazyload" loading="lazy" height="40px"></a>
                    <a href="#" class="text-decoration-none"><img src="./assets/image/visa.png" alt="" class="lazyload"
                        loading="lazy" height="40px"></a>
                  </div>
                  <div class="payment-card social-card">
                    <p class="pr-text5 m-0">Share:
                      <a href="#" target="_blank"><i class="fa-brands fa-facebook-f"></i></a>
                      <a href="#" target="_blank"><i class="fa-brands fa-instagram"></i></a>
                      <a href="#" target="_blank"><i class="fa-brands fa-whatsapp"></i></a>
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <section class="product-tabing common-section">
        <div class="container">
          <div class="row">
            <div class="col-md-12">
              <div class="card p-3 shadow">
                <nav>
                  <div class="nav nav-tabs mb-3" id="nav-tab" role="tablist">
                    <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab"
                      data-bs-target="#nav-description" type="button" role="tab" aria-controls="nav-description"
                      aria-selected="true">Description</button>

                    <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-technical"
                      type="button" role="tab" aria-controls="nav-technical" aria-selected="false">Technical</button>
                    <!-- 
                    <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-reviews"
                      type="button" role="tab" aria-controls="nav-reviews" aria-selected="false">Reviews (0)</button> -->

                    <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab"
                      data-bs-target="#nav-delivery-returns" type="button" role="tab"
                      aria-controls="nav-delivery-returns" aria-selected="false">Delivery & Returns</button>
                  </div>
                </nav>
                <div class="tab-content p-3 border" id="nav-tabContent">
                  <div class="tab-pane fade active show" id="nav-description" role="tabpanel"
                    aria-labelledby="nav-description-tab">
                    <p>{{$p['long_desc']}}</p>
                  </div>
                  <div class="tab-pane fade" id="nav-technical" role="tabpanel" aria-labelledby="nav-technical-tab">
                    <div class="primary-tabing-card">
                      <div class="tabing-box">
                        <p>
                          <i class="fa-solid fa-bag-shopping"></i>
                          Weight
                        </p>
                        <h6>{{$p['weight_g']}} Grams</h6>
                      </div>
                    </div>
                    <div class="primary-tabing-card actiive-tabing-card">
                      <div class="tabing-box">
                        <p>
                          <i class="fa-solid fa-bag-shopping"></i>
                          Metal
                        </p>
                        <h6>{{$p['front_metal']['name']}}</h6>
                      </div>
                    </div>
                    <div class="primary-tabing-card">
                      <div class="tabing-box">
                        <p>
                          <i class="fa-solid fa-bag-shopping"></i>
                          Fineness
                        </p>
                        <h6>{{$p['fineness']}}</h6>
                      </div>
                    </div>
                    <div class="primary-tabing-card actiive-tabing-card">
                      <div class="tabing-box">
                        <p>
                          <i class="fa-solid fa-bag-shopping"></i>
                          Manufacturer
                        </p>
                        <h6>{{$p['brand']}}</h6>
                      </div>
                    </div>
                    <!-- <div class="primary-tabing-card">
                      <div class="tabing-box">
                        <p>
                          <i class="fa-solid fa-bag-shopping"></i>
                          Dimensions
                        </p>
                        <h6>22.05mm Diameter</h6>
                      </div>
                    </div> -->
                  </div>
                <!--   <div class="tab-pane fade" id="nav-reviews" role="tabpanel" aria-labelledby="nav-reviews-tab">
                    <h6 class="common-accodian-title">Gold Sovereign Queen Elizabeth 4th Head (1998-2015)</h6>
                    <p>Rated 0 Based on 0 Reviews</p>
                  </div> -->
                  <div class="tab-pane fade" id="nav-delivery-returns" role="tabpanel"
                    aria-labelledby="nav-delivery-returns-tab">
                    <h6 class="common-accodian-title">
                      <p class="mb-2">We offer Multiple delivery options which may meet your requirement. The delivery
                        services mainly used are Royal mail, DHL and Fedex. All products are delivered in a secure
                        packaging and are fully insured.</p>
                      <h6 class="common-accodian-title">There are mainly three delivery options-</h6>
                      <ul class="delivery-policy">
                        <li>
                          Free Insured delivery-2-5 working days
                        </li>
                        <li>Next day delivery-The product would be delivered by 1 p.m. on the next day of placing and
                          order</li>
                        <li>Premium Delivery- The orders will be delivered by our delivery team.</li>
                      </ul>
                      <h6 class="common-accodian-title"><i class="fa-solid fa-arrow-rotate-left"></i> Returns</h6>
                      <p>The Bullion Products that we sell are dependent upon the fluctuations in the financial market
                        which are beyond our control,therefore the right to cancel under Regulation 13 of the Consumer
                        Protection (Distance Selling )Regulation 2000 does not apply on the same. If in case, there is a
                        consequence of cancellation of an order after it has been placed a fee of £100 would be charge
                        in
                        metals price would be charged as a cancellation fee. The cancellation policy is applicable to
                        all
                        bullion in stock and pre-order products. The refund would be only done if you meet the
                        requirements of order cancellation policy.</p>
                      <p>In case we run out of stock for a particular product you have ordered, our team would contact
                        you
                        and offer you an alternative product that we have in stock or else we will arrange a full refund
                        for you.</p>
                      <p>For any further queries regarding the deliveries and return you can refer to the FAQs.</p>
                  </div>
                </div>
              </div>



            </div>
          </div>
        </div>
      </section>
    </div>
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
            @forelse($newArrivals as $p)
            <?php
                if($p['front_stock_type'] == 1){
                  $prefix = 'buillion';
                }else if($p['front_stock_type'] == 2){
                  $prefix = 'preowned';                
                }else if($p['front_stock_type'] == 3){
                  $prefix = 'diamond';
                }
            ?> 
            <div class="item">
              <div class="product-card h-100" data-label="NEW">
                <div class="product-card-container">
                  <div class="product-img">
                    <a href="{{ route('ext.product', ['category' => $prefix, 'slug' => $p['slug']]) }}" rel="noopener">
                      @if(!empty($p['image']))
                      <img src="{{ $p['image'] }}" alt="{{ $p['name'] ?? 'Product' }}" class="img-fluid">
                      @else
                      <img src="{{ asset('assets/image/logo-dark-product-final.svg') }}" alt="No image" class="img-fluid">
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
    
  </main>


<!--   <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
  <img src="{{ $p['image'] ?: asset('assets/images/placeholder-bar.svg') }}" class="w-full h-auto object-contain bg-white rounded-xl p-6">
  <div>
    <h1 class="text-2xl font-semibold">{{ $p['title'] }}</h1>
    <p class="text-neutral-600 mt-1">{{ $p['metal'] }} · {{ number_format($p['weight_g'] ?? 0,3) }} g · {{ $p['brand'] ?? '—' }}</p>
    <p class="mt-4 text-3xl font-bold">£<span id="livePrice">{{ number_format($price ?? 0,2) }}</span></p>

   

    {{-- Optional: show raw API data for debugging --}}
    {{-- <pre class="mt-6 text-xs bg-neutral-100 p-3 rounded">{{ json_encode($p['raw'], JSON_PRETTY_PRINT) }}</pre> --}}
  </div>
</div> -->
@push('scripts')
<script>
async function refreshPrice(){
  try{
    // We don't know the page here, but our controller scans page 1; adapt if needed
    const r = await fetch('/api/products/{{ $p['external_id'] }}' + '/price?qty=' + (document.querySelector('input[name="qty"]').value || 1), { cache: 'no-store' });
    if (!r.ok) return;
    const j = await r.json();
    if (j.price_gbp != null) document.getElementById('livePrice').textContent = Number(j.price_gbp).toFixed(2);
  }catch(e){}
}
refreshPrice(); setInterval(refreshPrice, 30000);

// Update price when qty changes (multibuy)
  $('.qtyplus').click(function() {
      let qtyInput = document.querySelector('input[name="qty"]');
      // let qty = qtyInput.value;
      setTimeout(() => {
          qtyInput.dispatchEvent(new Event('change'));
      }, 500);
  });

  $('.qtyminus').click(function() {
    let qtyInput = document.querySelector('input[name="qty"]');
    // let qty = qtyInput.value;
    setTimeout(() => {
        qtyInput.dispatchEvent(new Event('change'));
    }, 500);
  });
  
$('input[name="qty"]').on('change', function() {
    refreshPrice();
});
document.querySelector('input[name="qty"]').addEventListener('input', () => {
  refreshPrice();
});
</script>
@endpush
@endsection
