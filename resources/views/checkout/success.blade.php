{{-- resources/views/checkout/success.blade.php --}}
@extends('layouts.app')
@section('title','Order confirmed')
@section('content')
<main class="container my-5 rounded shadow">
    <section class=" py-5 cart-empty-section">

        <div class="text-center mb-5">
            <h1 class="text-success fw-bold">Thank You for Your Order!</h1>
            <p class="lead">Your order <strong>{{ $order->order_no }}</strong> has been paid successfully.</p>
        </div>
        @isset($declarationUrl)
        <!-- <div class="alert alert-info d-flex align-items-center justify-content-between flex-wrap gap-2 mb-4" role="alert">
            <div class="me-2">
                Please fill out the required <strong>Compulsory Buying Form</strong> to complete your purchase.
            </div>
            <a href="{{ $declarationUrl }}"
                class="btn btn-dark">
                Fill the Compulsory Buying Form
            </a>
        </div> -->
        <div class="alert alert-warning border-0 shadow-sm d-flex align-items-center justify-content-between flex-wrap gap-2 mb-4" role="alert" style="background:#fff8e6;">
            <div class="d-flex align-items-start">
                <div class="me-3 d-inline-flex align-items-center justify-content-center rounded-circle" style="width:36px;height:36px;background:#ffe8b3;">
                    <span aria-hidden="true" style="font-size:18px;line-height:1;">🛡️</span>
                </div>
                <div>
                    <div class="fw-semibold mb-1" style="color:#7a5a00;">One quick step to finish</div>
                    <div class="text-muted">
                        Thanks—your order has been placed. To help keep everyone safe, please take a moment to complete the
                        <strong>Compulsory Buying Form</strong>. It’s quick and ensures we can process your purchase smoothly.
                    </div>
                </div>
            </div>

            <a href="{{ $declarationUrl }}" class="btn btn-dark d-block mx-auto">
                Complete form (2–3 mins)
            </a>

        </div>

        @endisset

        <!-- Order Summary -->
        <div class="card mb-5 shadow-sm">
            <div class="card-header bg-light">
                <h5 class="mb-0">Order Summary</h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless mb-0">
                    <tbody>
                        <tr>
                            <th scope="row">Subtotal:</th>
                            <td class="text-end">£{{ number_format($totals['subtotal'], 2) }}</td>
                        </tr>
                        <tr>
                            <th scope="row">VAT:</th>
                            <td class="text-end">£{{ number_format($totals['vat'], 2) }}</td>
                        </tr>
                        <tr class="border-top">
                            <th scope="row" class="h5">Total:</th>
                            <td class="text-end h5">£{{ number_format($totals['total'], 2) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Order Items -->
        <div class="card shadow-sm mb-5">
            <div class="card-header bg-light">
                <h5 class="mb-0">Order Items</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Image</th>
                                <th>Title</th>
                                <th>Product ID</th>
                                <th>External ID</th>
                                <th class="text-center">Qty</th>
                                <th class="text-end">Unit Price</th>
                                <th class="text-end">Line Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->items as $it)
                            <tr>
                                <td style="width: 70px;">
                                    @if($it->image_url)
                                    <img src="{{ $it->image_url }}" alt="{{ $it->title }}" class="img-fluid rounded" style="width: 60px; height: 60px; object-fit: cover;">
                                    @else
                                    <span class="text-muted">No Image</span>
                                    @endif
                                </td>
                                <td>{{ $it->title }}</td>
                                <td>{{ $it->product_id ?? '—' }}</td>
                                <td>{{ $it->external_id ?? '—' }}</td>
                                <td class="text-center">{{ $it->qty }}</td>
                                <td class="text-end">£{{ number_format($it->unit_gbp, 2) }}</td>
                                <td class="text-end fw-semibold">£{{ number_format($it->line_gbp, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Continue Shopping Button -->
        <div class="text-center empty-card-section">
           <a href="{{ route('ext.catalog', ['category' => 'bullion']) }}"><button class="common-primary-btn"><i
                              class="fa-solid fa-bag-shopping"></i> Continue Shopping</button></a>
        </div>
    </section>
</main>


@endsection