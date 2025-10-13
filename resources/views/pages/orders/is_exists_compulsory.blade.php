@extends('layouts.app')

@section('title', 'Form Already Submitted')

@section('content')
<main class="container my-5 already-declare-page">
  <div class="row justify-content-center">
    <div class="col-lg-12">

      <div class="card border-0">
        <div class="card-body text-center">

          {{-- Warning icon --}}
          <div class="mb-3">
            <div class="mx-auto d-inline-flex align-items-center justify-content-center rounded-circle"
                 style="width:64px;height:64px;background:#fff7e6;border:1px solid #ffe3a3;">
              <span class="fs-3" style="line-height:1;">⚠️</span>
            </div>
          </div>

          {{-- Heading & copy --}}
          <h1 class="h4 fw-bold mb-2">Form already submitted</h1>
          <p class="mb-4">
            A <strong>Compulsory Buying Form</strong> has already been submitted for
            @isset($order)
              <strong>Order #{{ $order->order_no }}</strong>.
            @else
              this order.
            @endisset
            You can’t submit another entry for the same order.
          </p>

          {{-- Meta (optional) --}}
          <div class="d-inline-block text-start mb-4" style="max-width:520px;">
            <ul class="list-unstyled small text-muted mb-0">
              @isset($order->created_at)
                <li class="mb-1"><strong>Order date:</strong> {{ $order->created_at->format('d M Y, H:i') }}</li>
              @endisset
              @isset($existingFormSubmittedAt)
                <li class="mb-1"><strong>Form submitted:</strong> {{ \Carbon\Carbon::parse($existingFormSubmittedAt)->format('d M Y, H:i') }}</li>
              @endisset
            </ul>
          </div>

          {{-- Actions --}}
          <div class="d-flex flex-wrap gap-2 justify-content-center empty-card-section">
            @isset($order)
              {{-- If you have a "view existing form" page, uncomment: --}}
              {{-- <a href="{{ route('orders.declaration.view', $order) }}" class="btn btn-outline-warning">
                View existing form
              </a> --}}
              <a href="{{ route('order.details', $order->id) }}" class="btn common-secondary-btn">
                Back to Order
              </a>
            @endisset
            <!-- <a href="{{ route('dashboard') }}" class="btn btn-light">
              Go to Dashboard
            </a> -->
             <a href="{{ url('/') }}"><button class="common-primary-btn"><i
                        class="fa-solid fa-bag-shopping"></i> Continue Shopping</button></a>
          </div>

        </div>
      </div>

    </div>
  </div>
</main>
@endsection
