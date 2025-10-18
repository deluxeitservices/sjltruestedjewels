@extends('layouts.app')

@section('title', 'Form Submitted')

@section('content')
<main class="container my-5 already-declare-page">
  <div class="row justify-content-center">
    <div class="col-lg-12">

      <div class="card border-0">
        <div class="card-body text-center">

          <div class="mb-3">
            <div class="mx-auto d-inline-flex align-items-center justify-content-center rounded-circle"
                 style="width:64px;height:64px;background:#e9f7ef;">
              <span class="fs-3" style="line-height:1;">✅</span>
            </div>
          </div>

          <h1 class="h3 fw-bold mb-2">Thank you!</h1>
          <p class="mb-4">
            Your <strong>Compulsory Buying Form</strong> has been submitted successfully.
          </p>

          @if(!empty($order))
            <div class="mb-3">
              <div class="small text-muted">Order Number</div>
              <div class="fw-semibold">{{ $order->order_no }}</div>
            </div>
          @endif

          <!-- <p class="mb-4">
            We’ll review your details and aim to process your payment
            within <strong>24–48 hours</strong> (weekdays) or by <strong>8 pm</strong>, whichever comes later.
          </p> -->

          <div class="d-flex flex-wrap gap-2 justify-content-center">
            <a href="{{ route('ext.catalog', ['category' => 'bullion']) }}" class="common-primary-btn gap-3"><i
                        class="fa-solid fa-bag-shopping"></i>
              Continue Shopping
            </a>

            @if(!empty($order))
              <a href="{{ route('order.details', $order->id) }}" class="btn common-secondary-btn ">
                View Order
              </a>
            @endif
          </div>

          <hr class="my-4">

          <p class="small text-muted mb-0">
            If you have questions, just reply to the confirmation email or contact our support team.
          </p>

        </div>
      </div>

    </div>
  </div>
</main>
@endsection
