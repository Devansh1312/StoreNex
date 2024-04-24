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
                                <div class="col-sm-4 bg-c-lite-green user-profile">
                                    <div class="card-block text-center text-white">
                                        <div class="m-b-25">
                                            <div id="carouselExample" class="carousel slide" data-ride="carousel">
                                                <div class="carousel-inner">
                                                    @foreach(explode(',', $product->image) as $key => $image)
                                                        <div class="carousel-item {{ $key === 0 ? 'active' : '' }}">
                                                            <img src="{{ asset('storage/ProductIMG/' . $image) }}" class="img-fluid img-radius" class="img-fluid img-radius mx-auto d-block" style="max-width: 300px; max-height: 300px;" alt="Product Image">
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <a class="carousel-control-prev" href="#carouselExample" role="button" data-slide="prev">
                                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                    <span class="sr-only">Previous</span>
                                                </a>
                                                <a class="carousel-control-next" href="#carouselExample" role="button" data-slide="next">
                                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                    <span class="sr-only">Next</span>
                                                </a>
                                            </div>
                                        </div>
                                        <h6 class="f-w-600">{{ $product->name }}</h6>
                                        <p>Product</p>
                                        <i class="mdi mdi-square-edit-outline feather icon-edit m-t-10 f-16"></i>
                                    </div>
                                </div>
                                <div class="col-sm-8">
                                    <div class="card-block">
                                        <h6 class="m-b-20 p-b-5 b-b-default f-w-600">Information</h6>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <p class="m-b-10 f-w-600">Product Name</p>
                                                <h6 class="text-muted f-w-400">{{ $product->name }}</h6>
                                            </div>
                                            <div class="col-sm-6">
                                                <p class="m-b-10 f-w-600">Subcategory</p>
                                                <h6 class="text-muted f-w-400">{{ $product->subcategory ? $product->subcategory->name : 'N/A' }}</h6>
                                            </div>
                                        </div>
                                        <!-- Fetch and display the Category name -->
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <p class="m-b-10 f-w-600">Category</p>
                                                @if ($product->subcategory && $product->subcategory->productCategory)
                                                    <h6 class="text-muted f-w-400">{{ $product->subcategory->productCategory->name }}</h6>
                                                @else
                                                    <p class="text-muted">Category not available</p>
                                                @endif
                                            </div>
                                            <div class="col-sm-6">
                                                <p class="m-b-10 f-w-600">Price</p>
                                                <h6 class="text-muted f-w-400">{{ $product->price }} ₹</h6>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <p class="m-b-10 f-w-600">Description</p>
                                                <h6 class="text-muted f-w-400">{!! $product->description !!}</h6>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <button class="btn btn-primary" onclick="window.location='{{ route('Product') }}'">Close</button>
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
