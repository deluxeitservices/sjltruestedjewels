{{-- resources/views/pages/cart.blade.php --}}
@extends('layouts.app')
@section('title','Your Cart')
@section('content')
<main>
  @if(session('error'))
    <div class="mb-4 p-3 border border-red-300 bg-red-50 text-red-700 rounded">{{ session('error') }}</div>
  @endif

  @if(empty($totals['items']))
    <p>Your cart is empty.</p>
  @else
  <section class="h-100 h-custom cart-listing-page">
    <div class="container py-5 h-100">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col">
          <div class="card">
            <div class="card-body">
              <div class="row">

                <div class="col-lg-7">
                  <h5 class="mb-3">
                    <a href="{{ route('ext.catalog') }}" class="cart-lisitng-title">
                      <i class="fas fa-long-arrow-alt-left me-2"></i>Continue shopping
                    </a>
                  </h5>
                  <hr>

                  <div class="cart-list">
                    <div class="cart-title">
                      <h5>Your Basket <span>({{ $totals['distinct_items'] }})</span></h5>
                    </div>
                    <p class="mb-0">You have {{ $totals['total_quantity'] }} items in your cart</p>
                  </div>

                  <div class="cart-listing-main-box">
                    @foreach($totals['items'] as $ci)
                      <div class="card mb-3" id="item-{{ $ci['item_id'] }}">
                        <div class="card-body cart-listing-content">
                          <div class="cart-details">
                            <div class="qunaty-box">
                              <div>
                                <img src="{{ $ci['image'] }}" class="img-fluid" alt="Shopping item" style="width:65px;">
                              </div>
                              <div class="ms-3">
                                <h5>{{ $ci['title'] }}</h5>
                                <p class="small mb-0">{{ $ci['front_metal'] ?? '—' }}</p>
                                <p>@if(!empty($ci['weight_g'])) · {{ number_format($ci['weight_g'],3) }} g @endif</p>
                              </div>
                            </div>

                            <div class="qunaty-item">
                              <div class="d-flex align-items-center gap-2">
                                <button type="button" class="btn btn-outline-secondary px-2 js-qty-dec" data-item="{{ $ci['item_id'] }}">-</button>
                                <input type="number"
                                       class="form-control text-center js-qty-input"
                                       value="{{ $ci['qty'] }}"
                                       min="0"
                                       data-item="{{ $ci['item_id'] }}"
                                       style="width:70px;">
                                <button type="button" class="btn btn-outline-secondary px-2 js-qty-inc" data-item="{{ $ci['item_id'] }}">+</button>
                              </div>

                              <div class="price-cart-listing">
                                <h5>£<span class="unit" data-item="{{ $ci['item_id'] }}">{{ number_format($ci['unit'], 2) }}</span></h5>
                                <div class="text-muted small">Line: £<span class="line" data-item="{{ $ci['item_id'] }}">{{ number_format($ci['line'], 2) }}</span></div>
                              </div>

                              <button class="btn btn-link text-danger p-0 js-remove" data-item="{{ $ci['item_id'] }}">
                                <i class="fas fa-trash-alt"></i>
                              </button>
                            </div>
                          </div>
                        </div>
                      </div>
                    @endforeach
                  </div>
                </div>

                <div class="col-lg-5">
                  <div class="card order-summary-card text-white rounded-3">
                    <div class="card-body order-summary-main-box">
                      <div class="order-summary-box">
                        <h4>Order Summary</h4>
                      </div>

                      <div class="order-price">
                        <p>Subtotal ( <span id="qty-sum">{{ $totals['total_quantity'] }}</span> )</p>
                        <h6><strong>£<span id="subtotal">{{ number_format($totals['subtotal'], 2) }}</span></strong></h6>
                      </div>

                      <div class="shpping-cart-box">
                        <span>VAT</span>
                        <span class="shipping-price-label"><strong>£<span id="vat">{{ number_format($totals['vat'], 2) }}</span></strong></span>
                      </div>

                      <div class="shipping-total">
                        <p>Total</p>
                        <h6 class="shipping-total-price text-lg mt-2">
                          <strong>£<span id="total">{{ number_format($totals['total'], 2) }}</span></strong>
                        </h6>
                      </div>
                    </div>

                    <div class="cart-checkout-btn p-3">
                      {{-- If guest, pressing this will redirect to login (auth middleware on /checkout) --}}
                      @auth
                        <a href="{{ route('checkout.show') }}" class="common-primary-btn w-100 text-center d-block">
                          <i class="fa-solid fa-lock"></i> Checkout
                        </a>
                      @endauth

                      {{-- If the user is a guest, show Login / Register --}}
                      @guest
                        <a href="{{ route('login') }}" class="common-primary-btn w-100 text-center d-block mb-2">
                          <i class="fa-solid fa-right-to-bracket"></i> Login to checkout
                        </a>
                       <!--  <a href="{{ route('register') }}" class="common-primary-btn w-100 text-center d-block">
                          <i class="fa-solid fa-user-plus"></i> Create account
                        </a> -->
                      @endguest

                      <a href="{{ route('ext.catalog') }}" class="common-primary-btn mt-2 w-100 text-center d-block">
                        <i class="fa-solid fa-bag-shopping"></i> Continue Shopping
                      </a>
                    </div>
                  </div>
                </div>

              </div><!-- row -->
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  @endif
</main>

@push('scripts')
<script>
// CSRF for fetch
const CSRF = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

function updateSummary(totals){
  document.getElementById('subtotal').textContent = Number(totals.subtotal).toFixed(2);
  document.getElementById('vat').textContent      = Number(totals.vat).toFixed(2);
  document.getElementById('total').textContent    = Number(totals.total).toFixed(2);
  const qtySum = document.getElementById('qty-sum'); if (qtySum) qtySum.textContent = totals.total_quantity;
}

function updateLines(totals){
  // Update per-line unit/line amounts
  (totals.items || []).forEach(L => {
    const u = document.querySelector('.unit[data-item="'+L.item_id+'"]');
    const ln = document.querySelector('.line[data-item="'+L.item_id+'"]');
    const inp = document.querySelector('.js-qty-input[data-item="'+L.item_id+'"]');
    if (u)  u.textContent  = Number(L.unit).toFixed(2);
    if (ln) ln.textContent = Number(L.line).toFixed(2);
    if (inp) inp.value = L.qty;
  });

  // Remove DOM cards that no longer exist
  const existing = Array.from(document.querySelectorAll('[id^="item-"]'))
    .map(el => parseInt(el.id.replace('item-',''), 10));
  const still = new Set((totals.items||[]).map(i => i.item_id));
  existing.forEach(id => {
    if (!still.has(id)) {
      const el = document.getElementById('item-'+id);
      if (el) el.remove();
    }
  });
}

async function postJson(url, body){
  const r = await fetch(url, {
    method: 'POST',
    headers: {
      'Content-Type':'application/json',
      'X-CSRF-TOKEN': CSRF
    },
    body: JSON.stringify(body)
  });
  if (!r.ok) throw new Error('Request failed');
  return await r.json();
}

async function applyQty(itemId, qty){
  try{
    const totals = await postJson('{{ route('cart.updateAjax') }}', {item_id:itemId, qty:qty});
    updateSummary(totals);
    updateLines(totals);
  }catch(e){ console.error(e); }
}

async function removeItem(itemId){
  try{
    const totals = await postJson('{{ route('cart.removeAjax') }}', {item_id:itemId});
    updateSummary(totals);
    updateLines(totals);
  }catch(e){ console.error(e); }
}

// +/- buttons
document.addEventListener('click', (ev) => {
  const dec = ev.target.closest('.js-qty-dec');
  const inc = ev.target.closest('.js-qty-inc');
  const rem = ev.target.closest('.js-remove');

  if (dec){
    const id = parseInt(dec.dataset.item, 10);
    const input = document.querySelector('.js-qty-input[data-item="'+id+'"]');
    let v = Math.max(0, parseInt(input.value || '1',10) - 1);
    input.value = v;
    applyQty(id, v);
  }
  if (inc){
    const id = parseInt(inc.dataset.item, 10);
    const input = document.querySelector('.js-qty-input[data-item="'+id+'"]');
    let v = Math.max(1, parseInt(input.value || '1',10) + 1);
    input.value = v;
    applyQty(id, v);
  }
  if (rem){
    const id = parseInt(rem.dataset.item, 10);
    removeItem(id);
  }
});

// typing directly
document.addEventListener('change', (ev) => {
  const inp = ev.target.closest('.js-qty-input');
  if (!inp) return;
  const id = parseInt(inp.dataset.item, 10);
  let v = Math.max(0, parseInt(inp.value || '1',10));
  inp.value = v;
  applyQty(id, v);
});
</script>
@endpush
@endsection
