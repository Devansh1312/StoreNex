@extends('frontend.layouts.app')

@section('content')
<!-- Start Banner Area -->
<section class="banner-area organic-breadcrumb">
   <div class="container">
      <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
         <div class="col-first">
            <h1>Order Detail Page</h1>
         </div>
      </div>
   </div>
</section>
<!-- End Banner Area -->
<!--================Order Details Area =================-->
<section class="order_details section_gap py-5">
    <div class="container">
        <!-- Order Information -->
        <div class="row mb-5">
            <div class="col-lg-6 mb-4 mb-lg-0 d-flex">
                <div class="card border-0 shadow-sm w-100">
                    <div class="card-body">
                        <h4 class="card-title">Order Info</h4>
                        <ul class="list-unstyled">
                            <li class="mb-2">
                                <strong>Order ID:</strong>
                                @if($order->razorpay_order_id == "COD")
                                    #Order_{{ $order->id }}
                                @else
                                    #{{ $order->razorpay_order_id }}
                                @endif
                            </li>
                            <li class="mb-2"><strong>Order Date:</strong> {{ $order->created_at->format('d-M-Y') }}</li>
                            <li class="mb-2"><strong>Total:</strong> ₹{{ number_format($order->total, 2) }}</li>
                            <li class="mb-2"><strong>Online Payment ID:</strong>{{ $order->razorpay_payment_id }}</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mb-4 mb-lg-0 d-flex">
                <div class="card border-0 shadow-sm w-100">
                    <div class="card-body">
                        <h4 class="card-title">Billing Details</h4>
                        <ul class="list-unstyled">
                            <li class="mb-2"><strong>Name:</strong> {{ $order->name }}</li>
                            <li class="mb-2"><strong>Email:</strong> {{ $order->email }}</li>
                            <li class="mb-2"><strong>Phone:</strong> {{ $order->phone }}</li>
                            <li class="mb-2"><strong>Address:</strong> {{ $order->addressline1 }}, {{ $order->addressline2 }}, {{ $order->city }}, {{ $order->district }}, {{ $order->zip_code }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Details Table -->
        <div class="order_details_table">
            <h2 class="mb-4">Order Details</h2>
            <div class="card border-0 shadow-sm">
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th style="color: black" scope="col">Product</th>
                                <th style="color: black" scope="col">Quantity</th>
                                <th style="color: black" scope="col">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->details as $detail)
                            <tr>
                                <td>{{ $detail->product->name }}</td>
                                <td>{{ $detail->quantity }}</td>
                                <td>₹{{ number_format($detail->price, 2) }}</td>
                            </tr>
                            @endforeach
                            <tr>
                                <td style="color: black" colspan="2">Grand Total:</td>
                                <td style="color: black">₹{{ number_format($order->total, 2) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="text-right" style="margin-top: 10px;">
                <a href="{{ route('OrderHistory')}}" class="btn btn-primary">Back</a>
            </div>        
        </div>
    </div>
</section>
<!--================End Order Details Area =================-->
@endsection
