@extends('admin.layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('admin/css/viewstaff.css') }}">
<!-- Content Wrapper. Contains page content -->
<div class="wrapper">
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
            </div><!-- /.container-fluid -->
        </div>

        <div class="page-content page-container" id="page-content">
            <div class="padding">
                <div class="row container d-flex justify-content-center">
                    <div class="col-xl-12 col-md-12">
                        <div class="card user-card-full">
                            <div class="row m-l-0 m-r-0">
                                <div class="col-sm-12">
                                    <div class="card-block">
                                        <!-- Order details -->
                                        <h6 class="m-b-20 p-b-5 b-b-default f-w-600">Order Details</h6>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <p class="m-b-10 f-w-600">ORDER ID</p>
                                                <h6 class="text-muted f-w-400">{{ $transaction->id }}</h6>
                                            </div>
                                            <div class="col-sm-6">
                                                <p class="m-b-10 f-w-600">Order Date</p>
                                                <h6 class="text-muted f-w-400">{{ $transaction->created_at }}</h6>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <p class="m-b-10 f-w-600"> Customer Name</p>
                                                <h6 class="text-muted f-w-400">{{ $transaction->name }}</h6>
                                            </div>
                                            <div class="col-sm-6">
                                                <p class="m-b-10 f-w-600">Customer Email</p>
                                                <h6 class="text-muted f-w-400">{{ $transaction->email }}</h6>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <p class="m-b-10 f-w-600">Customer Phone</p>
                                                <h6 class="text-muted f-w-400">{{ $transaction->phone }}</h6>
                                            </div>
                                            <div class="col-sm-6">
                                                <p class="m-b-10 f-w-600">Customer Address</p>
                                                <h6 class="text-muted f-w-400">{{ $transaction->addressline1 }}, {{ $transaction->addressline2 }}, {{ $transaction->city }}, {{ $transaction->district }}, {{ $transaction->zip_code }}</h6>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <p class="m-b-10 f-w-600">razorpay order id</p>
                                                <h6 class="text-muted f-w-400">{{ $transaction->razorpay_order_id }}</h6>
                                            </div>
                                            <div class="col-sm-4">
                                                <p class="m-b-10 f-w-600">razorpay payment id</p>
                                                <h6 class="text-muted f-w-400">{{ $transaction->razorpay_payment_id }}</h6>
                                            </div>
                                            <div class="col-sm-4">
                                                <p class="m-b-10 f-w-600">Payment Status</p>
                                                @php
                                                    switch($transaction->status) {
                                                        case 'Pending':
                                                            $statusClass1 = 'badge badge-secondary';
                                                            break;
                                                        case 'Paid':
                                                            $statusClass1 = 'badge badge-success';
                                                            break;
                                                        default:
                                                            $statusClass1 = 'badge badge-danger';
                                                    }
                                                @endphp
                                                <span class="{{ $statusClass1 }}">{{ ucfirst($transaction->status) }}</span>
                                            </div>
                                        </div>
                                        <!-- Transaction Status -->
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <p class="m-b-10 f-w-600">Order Status</p>
                                                @php
                                                    switch($transaction->order_status) {
                                                        case 'Pending':
                                                            $statusClass = 'badge badge-secondary';
                                                            break;
                                                        case 'Accepted':
                                                            $statusClass = 'badge badge-success';
                                                            break;
                                                        case 'Canceled':
                                                            $statusClass = 'badge badge-danger';
                                                            break;
                                                        default:
                                                            $statusClass = 'badge badge-secondary';
                                                    }
                                                @endphp
                                                <span class="{{ $statusClass }}">{{ ucfirst($transaction->order_status) }}</span>
                                            </div>
                                        </div>

                                        <!-- Products in the transaction -->
                                        <h6 style="margin-top:10px;" class="m-t-20 m-b-20 p-b-5 b-b-default f-w-600">Products</h6>
                                        <table class="table table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Quantity</th>
                                                    <th>Price</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($transactionDetails as $detail)
                                                <tr>
                                                    <td>{{ $detail->product->name }}</td>
                                                    <td>{{ $detail->quantity }}</td>
                                                    <td>₹ {{ number_format($detail->price, 2) }}</td>
                                                </tr>
                                                @endforeach
                                                <tr>
                                                    <th colspan="2">Total:</th>
                                                    <th>₹{{ number_format($transaction->total, 2) }}</th>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <!-- Close button -->
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <button class="btn btn-primary" onclick="window.location='{{ route('OrderManagement') }}'">Close</button>
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
    </div>
</div>
@endsection
