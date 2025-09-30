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
                    <div id="address-table" class="content-section">
                        <table
                            id="address-list-table"
                            class="display order-list-table table table-striped table-hover table-bordered align-middle table-responsive nowrap">
                            <thead class="taśble-light">
                                <tr>
                                    <th>Address</th>
                                    <th>House No</th>
                                    <th>Street Name</th>
                                    <th>City</th>
                                    <th>Postal Code</th>
                                    <th>Country</th>
                                    <th>Is Default</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($addresses as $address)
                                <tr>
                                    <td>{{ $address->address }}</td>
                                    <td>{{ $address->house_no }}</td>
                                    <td>{{ $address->street_name }}</td>
                                    <td>{{ $address->city }}</td>
                                    <td>{{ $address->postal_code }}</td>
                                    <td>{{ $address->country }}</td>
                                    <td>
                                        @if((int) $address->default_address === 1)
                                        <span class="badge badge-success">True</span> 
                                        @endif
                                    </td>

                                    <td class="primary-view">
                                        <a href="{{ route('address.details', $address->id) }}" class="common-primary-btn" data-order-id="{{ $address->id }}">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <!-- <a href="{{ route('orders.pdf', $address->id) }}" class="common-primary-btn" title="Download PDF">
                                            <i class="fa-solid fa-cloud-arrow-down"></i>
                                        </a> -->
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center">No orders found.</td>
                                </tr>
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