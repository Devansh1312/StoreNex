@extends('frontend.layouts.app')

@section('content')

{{-- <script src="https://maps.googleapis.com/maps/api/js?key=6LdEX5ApAAAAAAv1DZJRxgODgmuvuhfkcxHNu39-&callback=initMap" async defer></script> --}}
{{-- <script src="https://www.google.com/recaptcha/api.js" async defer></script> --}}
<script src="https://www.google.com/recaptcha/api.js" async defer></script>

<style>
        button[type="submit"] {
        height: 40px;
        width: 200px;
        justify-content: center;
        font-size: 13px;
        text-align: center;
        line-height: 40px; /* Adjusted to match the button's height for vertical centering */
        border: none;
        background-color: #007bff;
        color: #ffffff;
        cursor: pointer;
        transition: background-color 0.3s;
        position: relative;
        overflow: hidden;
        padding: 0 30px;
        border-radius: 50px;
        display: inline-block;
        text-transform: uppercase;
        font-weight: 500;
        -webkit-transition: all 0.3s ease;
        -moz-transition: all 0.3s ease;
        -o-transition: all 0.3s ease;
        transition: all 0.3s ease;
        background: linear-gradient(90deg, #7A048D 0%, #BD5DBF 100%);
    }
    button[type="submit"]:before {
        content: "";
        position: absolute;
        left: -145px;
        top: 0;
        height: 100%;
        width: 100%;
        background: #000;
        opacity: 0;
        transform: skew(40deg);
        transition: all 0.3s ease;
    }

    button[type="submit"]:hover {
        background-color: #0056b3; /* Darker shade for hover state */
    }


</style>
<!-- Start Banner Area -->
<section class="banner-area organic-breadcrumb">
    <div class="container">
        <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
            <div class="col-first">
                <h1>{{ $ContactUs->title }}</h1>
            </div>
        </div>
    </div>
</section>
<!-- End Banner Area -->
<!--================Contact Area =================-->
<section class="contact_area section_gap_bottom" style="padding: 30px">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6 mb-4">
                <div style="width: 100%; height: 300px; border: 1px solid #000000;">
                    <iframe
                        width="100%"
                        height="100%"
                        frameborder="0"
                        scrolling="no"
                        marginheight="0"
                        marginwidth="0"
                        src="https://maps.google.com/maps?q={{ urlencode($SystemSetting->address) }}&output=embed">
                    </iframe>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="contact_info">
                    <div class="info_item">
                        <i class="lnr lnr-home"></i>
                        @if(isset($SystemSetting))
                            <h6>{{ $SystemSetting->address }}</h6>
                            <p> </p>
                        @endif
                    </div>
                    <div class="info_item">
                        <i class="lnr lnr-phone-handset"></i>
                        @if(isset($SystemSetting))
                            <h6>+91 {{ $SystemSetting->phone }}</h6>
                            <p>Mon to Fri 9:30 am to 7 pm</p>
                        @endif
                    </div>
                    <div class="info_item">
                        <i class="lnr lnr-envelope"></i>
                        @if(isset($SystemSetting))
                            <h6>{{ $SystemSetting->email }}</h6>
                        @endif
                        <p>Send us your query anytime!</p>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-2 col-md-4 col-sm-6">
                        <!-- Left side column -->
                    </div>
                    <div class="col-lg-8 col-md-4 col-sm-6">
                        <!-- Form middle column -->
                        <div class="card shadow">
                            <div class="card-header">
                                <h3 class="card-title text-center">Contact Us</h3>
                            </div>
                            <div class="card-body">
                                <form class="contact_form" action="{{ route('submit.inquiry') }}" method="post" id="contactForm">
                                    @csrf <!-- CSRF Token for form submission security -->
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="name">Your Name<span>*</span></label>
                                                <input type="text" class="form-control" id="name" name="name" placeholder="Enter your name" value="{{ old('name') }}">
                                                @error('name') <div class="text-danger">{{ $message }}</div> @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="email">Email Address<span>*</span></label>
                                                <input type="email" class="form-control" id="email" name="email" placeholder="Enter email address" value="{{ old('email') }}">
                                                @error('email') <div class="text-danger">{{ $message }}</div> @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="phone">Phone Number<span>*</span></label>
                                                <input type="text" class="form-control" id="phone" name="phone" placeholder="Enter phone number" value="{{ old('phone') }}">
                                                @error('phone') <div class="text-danger">{{ $message }}</div> @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="message">Message<span>*</span></label>
                                                <textarea class="form-control" name="message" id="message" rows="3" placeholder="Enter Message">{{ old('message') }}</textarea>
                                                @error('message') <div class="text-danger">{{ $message }}</div> @enderror
                                            </div>
                                            <div class="form-group" style="overflow: hidden;">
                                                <div class="g-recaptcha" data-sitekey="6LdEX5ApAAAAAAv1DZJRxgODgmuvuhfkcxHNu39-"
                                                     style="transform: scale(0.8); transform-origin:0;"></div>
                                                @error('g-recaptcha-response') <div class="text-danger">{{ $message }}</div> @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row justify-content-end">
                                        <div class="col-md-6 text-right">
                                            <button type="submit">Send Message</button>
                                        </div>
                                    </div>
                                </form>                                
                            </div>                            
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-4 col-sm-6">
                        <!-- Right side column -->
                    </div>
                </div>
            </div>                            
        </div>
    </div>
</section>
<!-- Load Google reCAPTCHA script -->
<!--================Contact Area =================-->

<!-- Start Content Area -->

{{-- <section class="about-sec py-5">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <p>
                    {!! $ContactUs->content !!}
                </p>
            </div>
        </div>
    </div>
</section> --}}

<!-- End Content Area -->

@endsection
