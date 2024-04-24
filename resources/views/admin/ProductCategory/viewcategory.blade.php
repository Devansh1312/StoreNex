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
                                            <img src="{{ asset('storage/CategoryIMG/' . $productCategory->image) }}" class="img-fluid img-radius mx-auto d-block" style="max-width: 100px; max-height: 100px;" alt="Product Category Image">
                                        </div>
                                        <h6 class="f-w-600">{{ $productCategory->name }}</h6>
                                        <p>Product Category</p>
                                        <i class="mdi mdi-square-edit-outline feather icon-edit m-t-10 f-16"></i>
                                    </div>
                                </div>
                                <div class="col-sm-8">
                                    <div class="card-block">
                                        <h6 class="m-b-20 p-b-5 b-b-default f-w-600">Information</h6>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <p class="m-b-10 f-w-600">Name</p>
                                                <h6 class="text-muted f-w-400">{{ $productCategory->name }}</h6>
                                            </div>
                                            <div class="col-sm-6">
                                                <p class="m-b-10 f-w-600">Created At</p>
                                                <h6 class="text-muted f-w-400">{{ $productCategory->created_at->format('d-M-Y h:i A') }}</h6>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <button class="btn btn-primary" onclick="window.location='{{ route('ProductCategory') }}'">Close</button>
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
