@extends('layouts.app')
@section('title','External Catalogue')
@section('content')
<main class="product-listin-main">
  <section class="common-banner-section">
    <!-- <div class="common-baner-img">
             <img src="./assets/image/banner-3.png">
             </div> -->
    <div class="common-banner-content">
      @php
      $prefix = strtolower($prefix); // ensure case-insensitive matching
      @endphp
      <h2>
        @if ($prefix === 'bullion')
        Bars and Coins Product Listing
        @elseif ($prefix === 'preowned')
        Preowned Product Listing
        @elseif ($prefix === 'diamond')
        Diamond Product Listing
        @else
        Product Listing
        @endif
      </h2>
    </div>
  </section>
  <!-- product-lising-sectio -->
  <section class="new-arrivals-section product-listing-page">
    <div class="product-main-box">
      <div class="product-listing">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-3 col-sm-12">
              <div class="sidebar-stick sidebar-product">
                <form method="GET" action="{{ route('ext.catalog', ['category' => $prefix]) }}" id="filterForm" class="">
                  <input type="hidden" name="sort" id="sortInput" value="{{ request('sort') }}">

                  {{-- Header: Filter By + Reset --}}
                  <div class="side-title filter-box">
                    <div class="filter-title d-flex gap-2 align-items-center">
                      <h3 class="m-0">Filter By</h3>
                      <i class="fa-solid fa-filter"></i>
                    </div>
                    <div class="filter-title d-flex gap-2 align-items-center reset-btn">
                      <a href="{{ route('ext.catalog', ['category' => $prefix]) }}">Reset</a>
                    </div>
                  </div>

                  <div class="">
                    <aside class="side-area product-side side-shadow sidebar-filter">
                      <div class="side-content">
                        <div class="accordion" id="mainAccordion">
                          <div class="accordion-item border-0">
                            <h2 class="accordion-header p-0">
                              <div class="accordion-button collapsed"
                                type="button"
                                data-bs-toggle="collapse"
                                data-bs-target="#mainAccordionContent"
                                aria-expanded="true"
                                aria-controls="mainAccordionContent">
                                <i class="fa-solid fa-sliders"></i>&nbsp; Filters
                              </div>
                            </h2>

                            <div id="mainAccordionContent"
                              class="accordion-collapse collapse show filterby"
                              data-bs-parent="#mainAccordion">
                              <div class="accordion-body">
                                <div class="accordion" id="subAccordion">

                                  {{-- Search --}}
                                  <div class="accordion-item border-0">
                                    <h2 class="accordion-header p-0"></h2>
                                    <div data-bs-parent="#subAccordion">
                                      <div class="accordion-body d-flex">
                                          <div
                                            class="searbar-form-product" id="searchForm">
                                              <input
                                                type="text"
                                                name="search"
                                                id="search"
                                                value="{{ request('search') }}"
                                                class="form-control"
                                                placeholder="Search..."
                                                onkeydown="if(event.key==='Enter'){ event.preventDefault(); document.getElementById('filterForm').submit(); }">
                                              <button type="submit" class="btn btn-custom-search ms-2">
                                                <i class="fa fa-search"></i>
                                              </button>
                                            </div>
                                      </div>
                                    </div>
                                  </div>

                                  {{-- Category --}}
                                  @php
                                  $selectedCatSlugs = collect((array)request('category_slug'))->map(fn($v)=>strval($v))->all();
                                  $catOpen = count($selectedCatSlugs) > 0;
                                  @endphp
                                  <div class="accordion-item border-0">
                                    <h2 class="accordion-header p-0">
                                      <div class="accordion-button collapsed"
                                        data-bs-toggle="collapse"
                                        data-bs-target="#filterCategories">
                                        Category
                                      </div>
                                    </h2>
                                    <div id="filterCategories"
                                      class="accordion-collapse collapse show">
                                      <div class="accordion-body gold-menu">
                                        <div class="gold-type-main">
                                          @foreach($categories as $cat)
                                          <label class="text-decoration-none gold-type d-flex gap-2 flex-wrap mb-2 align-items-center">
                                            <span class="custom-checkbox">
                                              <input type="checkbox"
                                                name="category_slug[]"
                                                value="{{ $cat['slug'] }}"
                                                {{ in_array($cat['slug'], $selectedCatSlugs, true) ? 'checked' : '' }}
                                                onchange="document.getElementById('filterForm').submit();">
                                              <div class="checkmark"></div>
                                            </span>
                                            <p class="gold-textm-0" primary-color>{{ $cat['name'] }}</p>
                                            @if(($cat['count'] ?? 0) > 0)
                                            <span class="ms-auto text-muted small">({{ $cat['count'] }})</span>
                                            @endif
                                          </label>
                                          @endforeach
                                        </div>
                                      </div>
                                    </div>
                                  </div>

                                  {{-- Brand --}}
                                  @php
                                  $selectedBrandSlugs = collect((array)request('brand_slug'))->map(fn($v)=>strval($v))->all();
                                  $brandOpen = count($selectedBrandSlugs) > 0;
                                  @endphp
                                  <div class="accordion-item border-0">
                                    <h2 class="accordion-header p-0">
                                      <div class="accordion-button collapsed"
                                        data-bs-toggle="collapse"
                                        data-bs-target="#filterBrands">
                                        Brand
                                      </div>
                                    </h2>
                                    <div id="filterBrands"
                                      class="accordion-collapse collapse show">
                                      <div class="accordion-body gold-menu">
                                        <div class="gold-type-main">
                                          @foreach($brands as $b)
                                          <label class="text-decoration-none gold-type d-flex gap-2 flex-wrap mb-2 align-items-center">
                                            <span class="custom-checkbox">
                                              <input type="checkbox"
                                                name="brand_slug[]"
                                                value="{{ $b['slug'] }}"
                                                {{ in_array($b['slug'], $selectedBrandSlugs, true) ? 'checked' : '' }}
                                                onchange="document.getElementById('filterForm').submit();">
                                              <div class="checkmark"></div>
                                            </span>
                                            <p class="gold-textm-0" primary-color>{{ $b['name'] }}</p>
                                            @if(($b['count'] ?? 0) > 0)
                                            <span class="ms-auto text-muted small">({{ $b['count'] }})</span>
                                            @endif
                                          </label>
                                          @endforeach
                                        </div>
                                      </div>
                                    </div>
                                  </div>

                                  {{-- Weight --}}
                                  @php
                                  $selectedWeightSlugs = collect((array)request('weight_option_slug'))->map(fn($v)=>strval($v))->all();
                                  $weightOpen = count($selectedWeightSlugs) > 0;
                                  @endphp
                                  <div class="accordion-item border-0">
                                    <h2 class="accordion-header p-0">
                                      <div class="accordion-button collapsed"
                                        data-bs-toggle="collapse"
                                        data-bs-target="#filterWeights">
                                        Weight
                                      </div>
                                    </h2>
                                    <div id="filterWeights"
                                      class="accordion-collapse collapse show">
                                      <div class="accordion-body gold-menu">
                                        <div class="gold-type-main">
                                          @foreach($weights as $w)
                                          <label class="text-decoration-none gold-type d-flex gap-2 flex-wrap mb-2 align-items-center">
                                            <span class="custom-checkbox">
                                              <input type="checkbox"
                                                name="weight_option_slug[]"
                                                value="{{ $w['slug'] }}"
                                                {{ in_array($w['slug'], $selectedWeightSlugs, true) ? 'checked' : '' }}
                                                onchange="document.getElementById('filterForm').submit();">
                                              <div class="checkmark"></div>
                                            </span>
                                            <p class="gold-textm-0" primary-color>
                                              {{ $w['label'] ?: ($w['grams_exact'].' g') }}
                                            </p>
                                            @if(($w['count'] ?? 0) > 0)
                                            <span class="ms-auto text-muted small">({{ $w['count'] }})</span>
                                            @endif
                                          </label>
                                          @endforeach
                                        </div>
                                      </div>
                                    </div>
                                  </div>

                                </div> {{-- /#subAccordion --}}
                              </div>
                            </div>

                          </div>
                        </div>
                      </div>
                    </aside>
                  </div>
                </form>
              </div>
            </div>
            <div class="col-md-9">
              <!-- short input -->
              <div class="short-input">
                <div class="row justify-content-end" bis_skin_checked="1">
                  <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12"
                    bis_skin_checked="1">
                    <div class="form-group side-area product-side"
                      bis_skin_checked="1">
                      <select id="sortSelect" class="form-select" aria-label="sort-by">
                        <option value="">SORT BY</option>
                        <option value="price-asc" {{ request('sort')==='price-asc'  ? 'selected':'' }}>Price Low to High</option>
                        <option value="price-desc" {{ request('sort')==='price-desc' ? 'selected':'' }}>Price High to Low</option>
                        <option value="newest" {{ request('sort')==='newest'     ? 'selected':'' }}>Latest</option>
                      </select>
                    </div>
                  </div>
                </div>
                <!-- product listing -->
                <div class="row">
                  @if(($products->count() ?? 0) === 0)
                  <div class="col-12">
                    <div class="alert alert-warning alert-box" role="alert">
                      <div class="aleat-face-icon">
                        <i class="fa-regular fa-face-frown mt-1"></i>
                      </div>
                      <div>
                        <h5 class="m-0">No products available</h5>
                        <p class="mb-2">
                          @php
                          $activeFilters = array_filter([
                          'search' => request('search'),
                          'category_slug' => request('category_slug'),
                          'brand_slug' => request('brand_slug'),
                          'weight_option_slug' => request('weight_option_slug'),
                          ], fn($v) => !empty($v));
                          @endphp

                          @if(!empty($activeFilters))
                          We couldn't find any products matching your current filters.
                          @else
                          There are no products to show right now.
                          @endif
                        </p>
                        <div class="d-flex flex-wrap gap-2 justify-content-center">
                          <a href="{{ route('ext.catalog', ['category' => $prefix]) }}" class="btn common-primary-btn">
                            <i class="fa-solid fa-rotate-left"></i> Reset all filters
                          </a>

                          {{-- Keep the user's current query string but go to page 1 (if any filters were applied) --}}
                          @if(!empty($activeFilters))
                          @php
                            $category = request()->route('category'); // e.g. "bullion"
                          @endphp

                          <a href="{{ route('ext.catalog',
                                  array_merge(
                                    ['category' => $category],
                                    request()->except('page','category'),
                                    ['page' => 1]
                                  )
                               ) }}"
                             class="btn btn-sm btn-primary">
                            Keep filters &amp; try again
                          </a>

                          @endif
                        </div>

                        {{-- Optional: show active filters summary --}}
                        @if(!empty($activeFilters))
                        <div class="mt-3 small text-muted">
                          <strong>Active filters:</strong>
                          @if(request('search')) <span class="badge bg-light text-dark">Search: "{{ request('search') }}"</span> @endif
                          @foreach((array)request('category_slug') as $x)
                          <span class="badge bg-light text-dark">Category: {{ $x }}</span>
                          @endforeach
                          @foreach((array)request('brand_slug') as $x)
                          <span class="badge bg-light text-dark">Brand: {{ $x }}</span>
                          @endforeach
                          @foreach((array)request('weight_option_slug') as $x)
                          <span class="badge bg-light text-dark">Weight: {{ $x }}</span>
                          @endforeach
                        </div>
                        @endif
                      </div>
                    </div>
                  </div>
                  @else
                  @foreach($products as $p)
                  <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-6">
                    <div class="product-card h-100" data-label="SJL Trusted">
                      <div class="product-card-container">
                        <div class="product-img">
                          <a href="{{ route('ext.product', ['category' => $prefix, 'slug' => $p['slug']]) }}" class="block">
                            <img src="{{ $p['image'] ?: asset('assets/images/placeholder-bar.svg') }}" alt="{{ $p['title'] }}" class="img-fluid">
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
                          <h6 class="product-title">WG:{{ number_format($p['weight_g'] ?? 0,3) }} g</h6>
                          <small>{{ $p['brand'] }} | SKU: {{ $p['sku'] }}</small>
                          <div class="stock-box">
                            <h6 class="product-title">{{ $p['title'] }}</h6>
                            @if($p['availability'] === 'pre_order')
                            <p><img src="/assets/image/awaiting_stock.svg">Pre Order</p>
                            @elseif($p['availability'] === 'in_stock')
                            <p><img src="/assets/image/right.svg">In Stock</p>
                            @else
                            <p><img src="/assets/image/outof_stock.svg">Sold Out</p>
                            @endif
                          </div>
                          <div class="price-eyes-section">
                            <div>
                              <p class="product-price">From £
                                <span class="js-price" data-id="{{ $p['external_id'] }}">
                                  {{ number_format($p['display_price'] ?? 0, 2) }}
                                </span>
                              </p>
                            </div>
                            <div>
                              <form action="{{ route('ext.cart.add', ['category' => $prefix]) }}" method="post" class="flex items-center gap-2">
                                @csrf
                                <input type="hidden" name="external_id" value="{{ $p['external_id'] }}">
                                <input type="hidden" name="qty" value="1">
                                <button type="submit" aria-label="Add to cart">
                                  <i class="fa-solid fa-cart-arrow-down"></i>
                                </button>
                              </form>
                            </div>
                          </div>
                        </div> <!-- /product-info -->
                      </div>
                    </div>
                  </div>
                  @endforeach
                  @endif
                </div>

                {{-- pagination (only show when there are results and multiple pages) --}}
                @if(($products->count() ?? 0) > 0 && method_exists($products, 'hasPages') && $products->hasPages())
                <div class="row">
                  <nav aria-label="Page navigation product-pagination" class="product-pagination">
                    <ul class="pagination">
                      {{-- Prev --}}
                      <li class="page-item {{ $products->onFirstPage() ? 'disabled' : '' }}">
                        <a class="page-link pagination-prev" href="{{ $products->previousPageUrl() ?? '#' }}">Previous</a>
                      </li>

                      {{-- Page numbers --}}
                      @for ($i = 1; $i <= $products->lastPage(); $i++)
                        <li class="page-item {{ $products->currentPage() === $i ? 'active' : '' }}">
                          <a class="page-link" href="{{ $products->url($i) }}">{{ $i }}</a>
                        </li>
                        @endfor

                        {{-- Next --}}
                        <li class="page-item {{ $products->hasMorePages() ? '' : 'disabled' }}">
                          <a class="page-link paginatio-next" href="{{ $products->nextPageUrl() ?? '#' }}">Next</a>
                        </li>
                    </ul>
                  </nav>
                </div>
                @endif

                <!-- <div class="row">
                      <nav aria-label="Page navigation product-pagination" class="product-pagination">
                        <ul class="pagination">
                          {{-- Prev --}}
                          <li class="page-item {{ $products->onFirstPage() ? 'disabled' : '' }}">
                            <a class="page-link pagination-prev" href="{{ $products->previousPageUrl() ?? '#' }}">Previous</a>
                          </li>

                          {{-- Page numbers (simple full list; for large totals switch to a windowed loop) --}}
                          @for ($i = 1; $i <= $products->lastPage(); $i++)
                            <li class="page-item {{ $products->currentPage() === $i ? 'active' : '' }}">
                              <a class="page-link" href="{{ $products->url($i) }}">{{ $i }}</a>
                            </li>
                          @endfor

                          {{-- Next --}}
                          <li class="page-item {{ $products->hasMorePages() ? '' : 'disabled' }}">
                            <a class="page-link paginatio-next" href="{{ $products->nextPageUrl() ?? '#' }}">Next</a>
                          </li>
                        </ul>
                      </nav>
                    </div> -->
              </div>
            </div>
          </div>
        </div>
      </div>
  </section>

  {{-- Simple pager (compute from page/per_page/total) --}}
  @php
  $last = (int) ceil(($total ?? 0) / max(1, ($per_page ?? 12)));
  $cur = $page ?? 1;
  @endphp
  <div class="mt-6 flex gap-2">
    @if($cur > 1)
    <a class="px-3 py-1 border rounded" href="{{ route('ext.catalog', ['category' => $prefix, 'slug' => $p['slug']], ['page'=>$cur-1,'per_page'=>$per_page]) }}">Prev</a>
    @endif
    @if($cur < $last)
      <a class="px-3 py-1 border rounded" href="{{ route('ext.catalog', ['category' => $prefix, 'slug' => $p['slug']], ['page'=>$cur+1,'per_page'=>$per_page]) }}">Next</a>
      @endif
  </div>
</main>
@push('scripts')
<script>
  async function refreshPrices() {
    try {
      const nodes = document.querySelectorAll('.js-price');
      for (const el of nodes) {
        const id = el.getAttribute('data-id');
        const r = await fetch(`/api/products/${id}/price`, {
          cache: 'no-store'
        });
        if (!r.ok) continue;
        const j = await r.json();
        if (j.price_gbp != null) el.textContent = Number(j.price_gbp).toFixed(2);
      }
    } catch (e) {}
  }
  refreshPrices();
  setInterval(refreshPrices, 30000);
</script>
@endpush
@push('scripts')
<script>
  document.getElementById('filterForm').addEventListener('change', function(e) {
    const t = e.target;
    if (t.matches('input[name="category_slug[]"], input[name="brand_slug[]"], input[name="weight_option_slug[]"]')) {
      this.submit();
    }
  });
  (function() {
    const sel = document.getElementById('sortSelect');
    const form = document.getElementById('filterForm');
    const hid = document.getElementById('sortInput');
    if (!sel || !form || !hid) return;
    // ensure dropdown shows current value
    sel.value = "{{ request('sort') }}";
    sel.addEventListener('change', function() {
      hid.value = this.value || '';
      form.submit();
    });
  })();
</script>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    ['filterCategories', 'filterBrands', 'filterWeights'].forEach(function(id) {
      var panel = document.getElementById(id);
      if (!panel) return;
      var hasChecked = panel.querySelector('input[type="checkbox"]:checked');
      var btn = document.querySelector('.accordion-button[data-bs-target="#' + id + '"]');
      if (hasChecked) {
        panel.classList.add('show');
        if (btn) btn.classList.remove('collapsed');
      }
    });
  });
</script>
@endpush
@endsection