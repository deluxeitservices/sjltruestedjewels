{{-- resources/views/checkout/show.blade.php --}}
@extends('layouts.app')
@section('title','Checkout')
@section('content')
<main>
  <div class="common-form-page h-100 h-custom pyement-page">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <h2 class="common-title">Payment</h2>
          <p class="common-form-content">Payment today! Start building
            points and get access to exclusive discounts.
          </p>
        </div>
      </div>
      <div class="card mt-4 ">
        <div class="card-body">
          <div class="row common-form-row">
            <div class="col-lg-7">
              <!-- Billing address -->
              <div class="mb-4" id="billing-address-block" data-default='@json($defaultAddress)'>


                <div class="form-check mb-3">
                  <input class="form-check-input" type="checkbox" id="use-default">
                  <label class="form-check-label" for="use-default">
                    Use my default address
                  </label>
                </div>

                <!-- New address fields -->
                <div id="new-address-fields">
                  <form id="user-address">
                    <div class="row g-2">
                      <!-- <div class="col-md-6">
                        <label class="form-label">Full name</label>
                        <input id="addr_name" class="form-control" placeholder="Full name">
                      </div>
                      <div class="col-md-6">
                        <label class="form-label">Phone (optional)</label>
                        <input id="addr_phone" class="form-control" placeholder="">
                      </div> -->

                      <div class="col-12">
                        <label class="form-label">Address</label>
                        <input id="address" name="address" class="form-control" placeholder="Address">
                      </div>
                      <div class="col-6">
                        <label class="form-label">House
                          No. / Name</label>
                        <input id="house_no" name="house_no" class="form-control" placeholder="House No">
                      </div>
                      <div class="col-6">
                        <label class="form-label">Street
                          Name</label>
                        <input id="street_name" name="street_name" class="form-control" placeholder="Street Name">
                      </div>

                      <div class="col-md-6">
                        <label class="form-label">City</label>
                        <input id="city" name="city" class="form-control" placeholder="City">
                      </div>
                      <div class="col-md-3">
                        <label class="form-label">Postal/Zip</label>
                        <input id="postal_code" name="postal_code" class="form-control" placeholder="Postcode">
                      </div>
                      <div class="col-md-3">
                        <label class="form-label">Country</label>
                        <input id="country" name="country" class="form-control" value="" placeholder="Country">
                      </div>
                    </div>
                    <input type="hidden" name="address_id" id="address_id" value="">
                    <div class="mt-3">
                      <button type="button" id="continue-to-payment" class="btn btn-dark" disabled>
                        Continue to payment
                      </button>
                    </div>
                  </form>
                </div>
              </div>

              <form id="payment-form" style="display:none;">
                <div id="payment-element" class="mb-4"></div>
                <button id="submit" class="common-primary-btn">Pay now</button>
                <div id="error-message" class="text-red-600 mt-2"></div>
              </form>

            </div>
            <div class="col-md-5 col-12">
              <div
                class="card order-summary-card text-white rounded-3 text-white rounded-3 checkout-detail">
                <span class="item-cart-title">Basket Summary (<span>1</span>
                  Items)</span>
                <!-- <div class="card-body order-total-cardbody p-0">
                  <div class="pyement-total-text common-d-flex">
                    <h6>Product</h6>
                    <h6>Subtotal</h6>
                  </div>
                  <div class="common-d-flex">
                    <h6>Paraiba Tourmaline Ring × 1</h6>
                    <h6>£1,700.00</h6>
                  </div>
                    <div class="common-d-flex">
                    <h6>Subtotal</h6>
                    <h6>£1,700.00</h6>
                  </div>
                </div> -->
                <!-- <div class="card-body order-summary-main-box ">
                    <div class="card">
                      <div class="card-body cart-listing-content">
                        <div class="cart-details">
                          <div class="qunaty-box">
                            <div>
                              <img src="./assets/image/coin-1.png"
                                class="img-fluid rounded-3"
                                alt="Shopping item"
                                style="width: 65px;">
                            </div>
                            <div class="ms-3">
                              <h5>Great News! You will earn points from this
                                purchase 2928
                                Points</h5>
                              <p class="small mb-0">24ct (99.99%)</p>
                              <div class="qunaty-item">
                                <div class="price-cart-listing">
                                  <h5 class="mb-0">$900</h5>
                                </div>
                                <div class="delete-icon">
                                  <i class="fa-solid fa-trash"></i>
                                </div>
                              </div>
                            </div>
                          </div>

                        </div>
                      </div>
                    </div>
                    <div class="card">
                      <div class="card-body cart-listing-content">
                        <div class="cart-details">
                          <div class="qunaty-box">
                            <div>
                              <img src="./assets/image/coin-1.png"
                                class="img-fluid rounded-3"
                                alt="Shopping item"
                                style="width: 65px;">
                            </div>
                            <div class="ms-3">
                              <h5>Great News! You will earn points from this
                                purchase 2928
                                Points</h5>
                              <p class="small mb-0">24ct (99.99%)</p>
                              <div class="qunaty-item">
                                <div class="price-cart-listing">
                                  <h5 class="mb-0">$900</h5>
                                </div>
                                <div class="delete-icon">
                                  <i class="fa-solid fa-trash"></i>
                                </div>
                              </div>
                            </div>
                          </div>

                        </div>
                      </div>
                    </div>
                    <div class="card">
                      <div class="card-body cart-listing-content">
                        <div class="cart-details">
                          <div class="qunaty-box">
                            <div>
                              <img src="./assets/image/coin-1.png"
                                class="img-fluid rounded-3"
                                alt="Shopping item"
                                style="width: 65px;">
                            </div>
                            <div class="ms-3">
                              <h5>Great News! You will earn points from this
                                purchase 2928
                                Points</h5>
                              <p class="small mb-0">24ct (99.99%)</p>
                              <div class="qunaty-item">
                                <div class="price-cart-listing">
                                  <h5 class="mb-0">$900</h5>
                                </div>
                                <div class="delete-icon">
                                  <i class="fa-solid fa-trash"></i>
                                </div>
                              </div>
                            </div>
                          </div>

                        </div>
                      </div>
                    </div>
                  </div> -->
                <div class="card-body order-summary-main-box ">
                  <!-- <div class="card">
                      <div class="card-body cart-listing-content">
                        <div class="cart-details">
                          <div class="qunaty-box">
                            <div>
                              <img src="./assets/image/coin-1.png" class="img-fluid rounded-3" alt="Shopping item"
                                style="width: 65px;">
                            </div>
                            <div class="ms-3">
                              <h5>Great News! You will earn points from this purchase 2928
                                Points</h5>
                              <p class="small mb-0">24ct (99.99%)</p>
                              <div class="qunaty-item">
                                <div class="price-cart-listing">
                                  <h5 class="mb-0">$900</h5>
                                </div>
                                <div class="delete-icon">
                                  <i class="fa-solid fa-trash"></i>
                                </div>
                              </div>
                            </div>
                          </div>

                        </div>
                      </div>
                    </div> -->
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
                            <!-- <p class="small mb-0">{{ $ci['front_metal'] ?? '—' }}</p> -->
                            <p>
                              £<span class="unit" data-item="{{ $ci['item_id'] }}">{{ number_format($ci['unit'], 2) }}</span> * {{ $ci['qty'] }} =
                              <span class="line" data-item="{{ $ci['item_id'] }}">£{{ number_format($ci['line'], 2) }}</span>
                            </p>
                            <p>@if(!empty($ci['weight_g'])) · {{ number_format($ci['weight_g'],3) }} g @endif</p>
                          </div>
                        </div>

                        <div class="qunaty-item">
                          <!-- <div class="d-flex align-items-center gap-2"> -->
                          <!-- <button type="button" class="btn btn-outline-secondary px-2 js-qty-dec" data-item="{{ $ci['item_id'] }}">-</button>
                                <input type="number"
                                       class="form-control text-center js-qty-input"
                                       value="{{ $ci['qty'] }}"
                                       min="0"
                                       data-item="{{ $ci['item_id'] }}"
                                       style="width:70px;">
                                <button type="button" class="btn btn-outline-secondary px-2 js-qty-inc" data-item="{{ $ci['item_id'] }}">+</button> -->
                          <!-- <div class="number-count-box common-count-box">
                                 <div data-item="{{ $ci['item_id'] }}" class=" js-qty-dec">-</div>
                                  <input type="text" name="quantity" value="{{ $ci['qty'] }}"
                                       min="0"
                                       data-item="{{ $ci['item_id'] }}" class="qty text-center js-qty-input" >
                                  <div data-item="{{ $ci['item_id'] }}" class=" js-qty-inc">+</div>
                                </div> -->
                          <!-- </div> -->

                          <!-- <div class="price-cart-listing">
                                <h5>£<span class="unit" data-item="{{ $ci['item_id'] }}">{{ number_format($ci['unit'], 2) }}</span></h5>
                                <div class=" small">Line: £<span class="line" data-item="{{ $ci['item_id'] }}">{{ number_format($ci['line'], 2) }}</span></div>
                              </div> -->

                          <button class="btn btn-link text-danger p-0 js-remove" data-item="{{ $ci['item_id'] }}">
                            <i class="fas fa-trash-alt"></i>
                          </button>
                        </div>
                      </div>
                    </div>
                  </div>
                  @endforeach

                </div>
                <div class="order-summary-box">
                  <h4>Order total</h4>
                </div>
                <div class="order-price">
                  <p>Sub Total</p>
                  <h6>£{{ number_format($totals['subtotal'],2) }}</h6>
                </div>
                <!-- <div class="shpping-cart-box">
                    <span>Shipping</span>
                    <span class="shipping-price-label">Free</span>
                  </div> -->
                <div class="shpping-cart-box">
                  <span>VAT</span>
                  <span class="shipping-price-label">£{{ number_format($totals['vat'],2) }}</span>
                </div>
                <!-- <div class="shipping-total">
                    <p>Discount</p>
                    <h6 class="shipping-total-price">£0.00</h6>
                  </div> -->
                <div class="total-shipping-cart">
                  <p>Total</p>
                  <h6>£{{ number_format($totals['total'],2) }}</h6>
                </div>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

</main>
@push('scripts')
<!-- <script src="https://js.stripe.com/v3/"></script>
<script>
  const stripe = Stripe("{{ $publishableKey }}");
  const options = {
    clientSecret: "{{ $clientSecret }}",
    appearance: {
      theme: 'stripe'
    }
  };
  const elements = stripe.elements(options);
  const paymentElement = elements.create('payment');
  paymentElement.mount('#payment-element');

  document.getElementById('payment-form').addEventListener('submit', async (e) => {
    e.preventDefault();
    const {
      error
    } = await stripe.confirmPayment({
      elements,
      confirmParams: {
        return_url: "{{ route('checkout.success') }}",
      },
    });
    if (error) {
      document.getElementById('error-message').textContent = error.message || 'Payment failed.';
    }
  });
</script> -->
<script src="https://js.stripe.com/v3/"></script>
<script>
  const stripe = Stripe("{{ $publishableKey }}");
  const options = {
    clientSecret: "{{ $clientSecret }}",
    appearance: {
      theme: 'stripe'
    }
  };
  const elements = stripe.elements(options);
  let paymentElementMounted = false;

  // ---------- Address helpers ----------
  function readDefaultAddress() {
    const block = document.getElementById('billing-address-block');
    try {
      return JSON.parse(block.getAttribute('data-default') || '{}');
    } catch {
      return {};
    }
  }

  function fillAddress(a = {}) {
    document.getElementById('address').value = a.address || '';
    // document.getElementById('addr_name').value = a.name || '';
    // document.getElementById('addr_phone').value = a.phone || '';
    document.getElementById('house_no').value = a.house_no || ''; // map house_no -> house_no
    document.getElementById('street_name').value = a.street_name || ''; // map street_name -> street_name
    document.getElementById('city').value = a.city || '';
    document.getElementById('postal_code').value = a.postal_code || '';
    document.getElementById('country').value = (a.country || 'GB').toUpperCase();
  }

  function getBillingDetailsFromForm() {
    return {
      // name: document.getElementById('addr_name').value.trim(),
      // phone: document.getElementById('addr_phone').value.trim(),
      address: {
        address: document.getElementById('address').value.trim(),
        house_no: document.getElementById('house_no').value.trim(),
        street_name: document.getElementById('street_name').value.trim(),
        city: document.getElementById('city').value.trim(),
        postal_code: document.getElementById('postal_code').value.trim(),
        country: (document.getElementById('country').value || 'GB').trim().toUpperCase()
      }
    };
  }

  function isAddressComplete(bd) {
    return !!(
      bd.address.house_no &&
      bd.address.city &&
      bd.address.postal_code &&
      bd.address.country);
  }

  function saveAddressToServer(bd) {
    const res = fetch("{{ route('checkout.address.store') }}", {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
      },
      body: JSON.stringify({
        // name: bd.name,
        // phone: bd.phone,
        address: bd.address.address,
        house_no: bd.address.house_no,
        street_name: bd.address.street_name,
        city: bd.address.city,
        postal_code: bd.address.postal_code,
        country: bd.address.country,
        make_default: true // store as default if you want
      })
    });
    // if (!res.ok) throw new Error('Failed to save address');
    // return res.json();
  }

  function toggleButtonStates() {
    const continueBtn = document.getElementById('continue-to-payment');
    const payBtn = document.getElementById('submit'); // in payment form
    const complete = isAddressComplete(getBillingDetailsFromForm());
    continueBtn.disabled = !complete;
    // only enable Pay once payment form is visible
    if (document.getElementById('payment-form').style.display !== 'none') {
      payBtn.disabled = !complete;
    }
  }

  function setReadOnly(on) {
    ['address', 'house_no', 'street_name', 'city', 'postal_code', 'country']
    .forEach(id => {
      const el = document.getElementById(id);
      if (el) el.readOnly = on;
    });
  }

  // ---------- Wire up address UI ----------
  (function initAddress() {
    const useDefault = document.getElementById('use-default');
    const def = readDefaultAddress();
    const hiddenId   = document.getElementById('address_id');

    // default state
    toggleButtonStates();

    useDefault.addEventListener('change', () => {
      if (useDefault.checked) {
        fillAddress(def);
        setReadOnly(true);
        hiddenId.value = def.id || ''; // crucial: carry the ID to backend
      } else {
        setReadOnly(false);
        fillAddress({});
        hiddenId.value = '';

      };
      toggleButtonStates();
    });

    // live validation on input
    [ 'house_no', 'street_name', 'city', 'postal_code', 'country'].forEach(id => {
      const el = document.getElementById(id);
      if (el) el.addEventListener('input', toggleButtonStates);
    });

    // continue to payment -> show stripe form and mount once
    document.getElementById('continue-to-payment').addEventListener('click', () => {
      const bd = getBillingDetailsFromForm();
      if (!isAddressComplete(bd)) return;


      saveAddressToServer(bd); // persist in DB

      document.getElementById('billing-address-block').style.display = 'none';

      // Show payment form
      const pf = document.getElementById('payment-form');
      pf.style.display = 'block';

      // Mount Stripe element only once
      if (!paymentElementMounted) {
        const paymentElement = elements.create('payment');
        paymentElement.mount('#payment-element');
        paymentElementMounted = true;
      }

      // enable Pay button
      document.getElementById('submit').disabled = false;

      // Optionally, scroll to payment form
      pf.scrollIntoView({
        behavior: 'smooth',
        block: 'start'
      });
    });
  })();

  // ---------- Stripe submit ----------
  document.getElementById('payment-form').addEventListener('submit', async (e) => {
    e.preventDefault();
    const billing_details = getBillingDetailsFromForm();
    if (!isAddressComplete(billing_details)) {
      document.getElementById('error-message').textContent = 'Please complete your billing address.';
      return;
    }

    const {
      error
    } = await stripe.confirmPayment({
      elements,
      confirmParams: {
        return_url: "{{ route('checkout.success') }}",
        // payment_method_data: {
        //   billing_details
        // }
      }
    });

    if (error) {
      document.getElementById('error-message').textContent = error.message || 'Payment failed.';
    }
  });


  // function toggleButtonStates() {
  //   alert('adsf');
  //   const bd = getBillingDetailsFromForm();
  //   document.getElementById('continue-to-payment').disabled = !isAddressComplete(bd);
  // }
</script>


@endpush
@endsection