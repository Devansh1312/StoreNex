@extends('frontend.layouts.app')

@section('content')

<!-- Start Banner Area -->
<section class="banner-area organic-breadcrumb">
    <div class="container">
        <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
            <div class="col-first">
                <h1>Order History</h1>
            </div>
        </div>
    </div>
</section>
<!-- End Banner Area -->

<!--================Order History Area =================-->
<section class="cart_area">
    <div class="container">
        <div class="cart_inner">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th style="color: black" scope="col">Order ID</th>
                            <th style="color: black" scope="col">Order Date</th>
                            <th style="color: black" scope="col">Status</th>
                            <th style="color: black" scope="col">Price</th>
                            <th style="color: black" scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transactions as $transaction)
                            <tr>
                                <td>
                                    @if($transaction->razorpay_order_id == "COD")
                                        #Order_{{ $transaction->id }}
                                    @else
                                        #{{ $transaction->razorpay_order_id }}
                                    @endif
                                </td>
                                <td>{{ $transaction->created_at->format('d-M-Y') }}</td>
                                <td>
                                    @php
                                    $badgeClass = ''; // Initialize badge class variable
                                    switch($transaction->order_status) {
                                        case 'Pending':
                                            $badgeClass = 'badge-secondary';
                                            break;
                                        case 'Accepted':
                                            $badgeClass = 'badge-success';
                                            break;
                                        case 'Canceled':
                                            $badgeClass = 'badge-danger';
                                            break;
                                        default:
                                            $badgeClass = 'badge-secondary'; // Default class
                                            // Debugging
                                            // dd('Encountered unexpected status:', $transaction->status);
                                    }
                                    @endphp

                                    <span class="badge {{ $badgeClass }}" style="padding: 5px 10px; font-size: 12px;">{{ ucfirst($transaction->order_status) }}</span>
                                </td>  
                                <td>
                                    {{-- Calculate total price and quantity --}}
                                    @php
                                    $totalQuantity = 0;
                                    foreach($transaction->details as $detail) {
                                        $totalQuantity += $detail->quantity;
                                    }
                                    @endphp
                                    ₹ {{ number_format($transaction->total, 2) }} for {{ $totalQuantity }} items
                                </td>
                                <td><a href="{{ route('SingleOrder', ['id' => base64_encode($transaction->id)]) }}" class="btn btn-primary">View</a></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">No orders found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
<!--================End Order History Area =================-->

@endsection
