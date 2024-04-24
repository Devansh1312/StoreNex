@extends('frontend.layouts.app') @section('content')
<!-- Start Banner Area -->
<section class="banner-area organic-breadcrumb">
   <div class="container">
      <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
         <div class="col-first">
            <h1>CheckOut</h1>
         </div>
      </div>
   </div>
</section>
<!-- End Banner Area -->
<!--================Order Details Area =================-->
<section class="order_details section_gap py-5">
    <div class="container">
        <!-- Thank you message -->
        <div class="text-center mb-5">
            <h2 class="title_confirmation">Thank you. Your order has been Placed.</h2>
            <h4 class="title_confirmation">Check Your Email For Invoice.</h>
        </div>

        <!-- Order Information -->
        <div class="row mb-5">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h4 class="card-title">Order Info</h4>
                        <ul class="list-unstyled">
                            <li class="mb-2"><strong>Order ID:- </strong> {{ $transaction->id }}</li>
                            <li class="mb-2"><strong>Order Date:- </strong> {{ $transaction->created_at }}</li>
                            <li class="mb-2"><strong>Total:- </strong>₹ {{ number_format($transaction->total, 2) }}</li>
							<li class="mb-2"><strong>Payment method:- </strong>Cash On Delivery</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mb-4 mb-lg-0">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h4 class="card-title">Customer Details</h4>
                        <ul class="list-unstyled">
                            <li class="mb-2"><strong>Name:</strong> {{ $transaction->name }}</li>
                            <li class="mb-2"><strong>Email:</strong> {{ $transaction->email }}</li>
                            <li class="mb-2"><strong>Phone:</strong> {{ $transaction->phone }}</li>
                            <li class="mb-2"><strong>Address:</strong> {{ $transaction->addressline1 }}, {{ $transaction->addressline2 }}, {{ $transaction->city }}, {{ $transaction->district }}, {{ $transaction->zip_code }}</li>
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
                            @foreach($cartItems as $cartItem)
                            <tr>
                                <td>{{ $cartItem->product->name }}</td>
                                <td>x {{ $cartItem->quantity }}</td>
                                <td>₹ {{ number_format($cartItem->total_amount, 2) }}</td>
                            </tr>
                            @endforeach
                            <tr>
                                <td style="color: black" colspan="2">
                                    Grand Total :- 
                                </td>
                                <td style="color: black">₹ {{ number_format($transaction->total, 2) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<!--================End Order Details Area =================-->
 @endsection