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
            <p class="common-form-content">Phyment today! Start building
              points and get access to exclusive discounts.
            </p>
          </div>
        </div>
        <div class="card mt-4 ">
          <div class="card-body">
            <div class="row common-form-row">
              <div class="col-lg-7">
                <form id="payment-form">
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
<script src="https://js.stripe.com/v3/"></script>
<script>
const stripe = Stripe("{{ $publishableKey }}");
const options = {
  clientSecret: "{{ $clientSecret }}",
  appearance: { theme: 'stripe' }
};
const elements = stripe.elements(options);
const paymentElement = elements.create('payment');
paymentElement.mount('#payment-element');

document.getElementById('payment-form').addEventListener('submit', async (e) => {
  e.preventDefault();
  const {error} = await stripe.confirmPayment({
    elements,
    confirmParams: {
      return_url: "{{ route('checkout.success') }}",
    },
  });
  if (error) {
    document.getElementById('error-message').textContent = error.message || 'Payment failed.';
  }
});
</script>
@endpush
@endsection
