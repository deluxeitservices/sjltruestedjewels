@extends('layouts.app')
@section('title','Thank you')

@section('content')
<main class="container my-5">
  <div class="row justify-content-center">
    <div class="col-lg-8">
      <div class="card shadow-sm border-0">
        <div class="card-body p-4 p-md-5 text-center">

          <div class="mb-3">
            <div class="mx-auto d-inline-flex align-items-center justify-content-center rounded-circle"
                 style="width:64px;height:64px;background:#e9f7ef;">
              <span class="fs-3" style="line-height:1;">✅</span>
            </div>
          </div>

          <h1 class="h3 fw-bold mb-2">Thank you!</h1>

          @if(session('success'))
            <p class="text-muted mb-4">{{ session('success') }}</p>
          @else
            <p class="text-muted mb-4">Your inquiry has been submitted successfully.</p>
          @endif

          <div class="d-flex flex-wrap gap-2 justify-content-center">
            <a href="{{ route('sell.index') }}" class="btn btn-primary">
              Sell now
            </a>
            <a href="{{ url('/') }}" class="btn btn-outline-secondary">
              Continue shopping
            </a>
          </div>

        </div>
      </div>
    </div>
  </div>
</main>
@endsection
