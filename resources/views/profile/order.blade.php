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
                        <table
                            id="order-list-table"
                            class="display order-list-table table table-striped table-hover table-bordered align-middle table-responsive nowrap">
                            <thead class="table-light">
                                <tr>
                                    <th>Order</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Total</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($orders as $order)
                                <tr>
                                    <td>#{{ $order->order_no }}</td>
                                    <td>{{ \Carbon\Carbon::parse($order->created_at)->format('Y-m-d') }}</td>
                                    <td>{{ $order->status }}</td>
                                    <td>{{ number_format($order->total_gbp, 2) }}</td>
                                    <td class="primary-view">
                                        <!-- <a href="#" class="common-primary-btn">
                                            <i class="fa-solid fa-eye"></i>
                                        </a> -->
                                        <a href="{{ route('order.details', $order->id) }}" class="common-primary-btn" data-order-id="{{ $order->id }}">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        <a href="{{ route('orders.pdf', $order->id) }}" class="common-primary-btn" title="Download PDF">
                                            <i class="fa-solid fa-cloud-arrow-down"></i>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                {{-- <tr>
                                    <td colspan="5" class="text-center">No orders found.</td>
                                </tr> --}}
                                @endforelse
                            </tbody>
                        </table>

                        <!-- <div class="order-detail-section">
                            <div class="conttainer">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h6>Order Details</h6>
                                        <div class="detail-box">
                                            <h6>Product</h6>
                                            <h6>Total</h6>
                                        </div>
                                        <div class="sub-detail-box">
                                            <div class="order-image-box">
                                                <span class="category-detail-name">ring</span>
                                                <img src="./assets/image/gold-dimond.png">
                                            </div>
                                            <div class="order-detail-price">
                                                <span class="product-detail-price">
                                                    £450.00
                                                </span>
                                            </div>
                                        </div>
                                        <div class="order-shpping-text">
                                            <span>Shipping</span>
                                            <span>Free Shipping</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection