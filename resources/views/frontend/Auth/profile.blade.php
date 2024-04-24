@extends('frontend.layouts.app')
@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

<link rel="stylesheet" href="{{asset('frontend/css/profile.css')}}">
<section class="banner-area organic-breadcrumb">
    <div class="container">
        <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
            <div class="col-first">
                <h1>Profile Update Section</h1>
            </div>
        </div>
    </div>
</section>

<div class="page-content page-container" id="page-content">
    <div class="padding">
        <div class="row justify-content-center">
            <div class="col-xl-12 col-md-12">
                <div class="card user-card-full">
                    <div class="row m-l-0 m-r-0">
                        <div class="col-sm-3 bg-c-lite-green user-profile">
                            <div class="card-block text-center text-white">
                                <div class="m-b-25">
                                    <img src="https://img.icons8.com/bubbles/100/000000/user.png" class="img-radius"
                                        alt="User-Profile-Image">
                                </div>
                                <h4 class="f-w-600">{{ auth()->user()->name }}</h4>
                                <i class="mdi mdi-square-edit-outline feather icon-edit m-t-10 f-16"></i>
                            </div>
                        </div>
                        <div class="col-sm-9">
                            <div class="card-block">
                                <a href="{{ route('welcome') }}" class="btn-close"
                                    style="float:right; font-size:24px; text-decoration:none;">
                                    <i class="fas fa-times"></i>
                                </a>
                                <form action="{{ route('UpdateProfile') }}" method="post">
                                    @csrf
                                    <h6 class="m-b-20 p-b-5 b-b-default f-w-600">Information</h6>
                                    <div class="row mb-3">
                                        <!-- Add mb-3 for some spacing between rows -->
                                        <div class="col-sm-2">
                                            <p class="m-b-10 f-w-600">Name</p>
                                        </div>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" name="name"
                                                placeholder="Enter the name"
                                                value="{{ old('name', auth()->user()->name) }}" />
                                            @error('name')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-2">
                                            <p class="m-b-10 f-w-600">Email</p>
                                        </div>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" name="email"
                                                placeholder="Enter the Email"
                                                value="{{ old('email', auth()->user()->email) }}" />
                                            @error('email')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-2">
                                            <p class="m-b-10 f-w-600">Phone</p>
                                        </div>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" name="phone"
                                                placeholder="Enter the phone"
                                                value="{{ old('phone', auth()->user()->phone) }}" />
                                            @error('phone')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <h6 class="m-b-20 m-t-40 p-b-5 b-b-default f-w-600">Change Password</h6>
                                    <div class="row">
                                        <div class="col-md-4 form-group">
                                            <label for="old_password">Old Password</label>
                                            <input type="password" class="form-control" id="old_password"
                                                name="old_password">
                                            @error('old_password')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <label for="new_password">New Password</label>
                                            <input type="password" class="form-control" id="new_password"
                                                name="new_password">
                                            @error('new_password')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <label for="new_password_confirmation">Confirm Password</label>
                                            <input type="password" class="form-control" id="new_password_confirmation"
                                                name="new_password_confirmation">
                                            @error('new_password_confirmation')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12 text-right">
                                            <!-- Use text-end for Bootstrap 5 -->
                                            <button type="submit" class="btn btn-primary">Save</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection