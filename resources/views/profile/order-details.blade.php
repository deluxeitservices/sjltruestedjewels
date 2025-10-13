@extends('layouts.app')
@section('title', 'SJL')
@section('content')
<main class="profile-page">
    <div class="container py-5">
        <div class="row">
            <!-- Sidebar -->
            @include('profile.profilecommon')


            <!-- Content Area -->
            <div class="col-lg-9 col-md-12">
                <div class="pofile-content-card">
                    <div id="orders" class="content-section">
                        <div class="order-detail-section">
                            <div class="conttainer">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h6>Order Details</h6>
                                        <div class="detail-box">
                                            <h6>Product</h6>
                                            <h6>Total</h6>
                                        </div>
                                        @foreach($order->items as $item)
                                            <div class="sub-detail-box">
                                                <div class="order-image-box">
                                                    {{ $item->title ?? 'No Name' }}
                                                    @if($item->is_branded_item == 1)
                                                    <i class="fa-solid fa-tags text-warning" style="font-size: 1.1rem; margin-top: 2px; margin-left: 2px;"></i>
                                                    @endif
                                                    <span>x {{ $item->quantity }}</span>

                                                    @php
                                                    $img = $item->image_url;

                                                    @endphp

                                                    <img width="50" height="50" src="{{ $img }}" onclick="zoomImage('{{ $img }}')" style="cursor: pointer;">
                                                </div>
                                                <div class="order-detail-price">
                                                    <span class="product-detail-price">
                                                        £{{ number_format($item->unit_gbp, 2) }}
                                                    </span>
                                                </div>
                                            </div>
                                            <!-- <div class="order-shpping-text">
                                                <span>Shipping</span>
                                                <span>Free Shipping</span>
                                            </div> -->
                                        @endforeach
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-6">
                                      <div class="main-order-text-left d-flex justify-content-start">
                                          <p class="d-order-text04">Total:</p>
                                      </div>
                                  </div>
                                  <div class="col-md-6 col-sm-6 col-6">
                                      <div class="main-order-text-right d-flex justify-content-end">
                                          <p class="d-order-text03">£{{ number_format($order->total_gbp, 2) }}</p>
                                      </div>
                                  </div>
                                  <div class="col-md-6 col-sm-6 mt-4">
                                  </div>
                                  <div class="col-md-6 col-sm-6 mt-4">
                                      <div class="order-address-box2 order-add-box h-100 ps-4 pe-4">
                                          <p class="order-add-title"><strong>Shipping Address</strong></p>
                                          <p class="order-add-text">
                                              {{ $order->user_address->address }},
                                              {{ $order->user_address->house_no }},
                                              {{ $order->user_address->street_name }},
                                              {{ $order->user_address->city }} {{ $order->user_address->state }},
                                              {{ $order->user_address->postal_code }}, {{ $order->user_address->country }}
                                          </p>
                                      </div>
                                  </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection