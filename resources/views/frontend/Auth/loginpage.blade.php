@extends('frontend.layouts.app') @section('content')
<!-- Sweat Alert -->
<script src="{{asset('plugins/sweetalert2/sweetalert2.min.js')}}"></script>
<link rel="stylesheet" href="{{asset('plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css')}}">
<link rel="stylesheet" href="{{asset('plugins/toastr/toastr.min.css')}}">
<script src="{{asset('plugins/toastr/toastr.min.js')}}"></script>
<style>
    .password-toggle {
        position: relative;
    }

    .password-toggle .toggle-password {
        position: absolute;
        top: 50%;
        right: 10px; /* Adjust as needed */
        transform: translateY(-50%);
        cursor: pointer;
    }
</style>

<!-- Start Banner Area -->
<section class="banner-area organic-breadcrumb">
    <div class="container">
        <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
            <div class="col-first">
                <h1>Login/Register</h1>
                <nav class="d-flex align-items-center">
                    <a href="{{ route('welcome') }}">Home <span class="lnr lnr-arrow-right"></span>
                    </a>
                    <a href="{{ route('customerloginpage') }}">Login</a>
                    <a href="{{ route('Customerregisterpage') }}">/Register</a>
                </nav>
            </div>
        </div>
    </div>
</section>
<!-- End Banner Area -->
<!--================Login Box Area =================-->
<section class="login_box_area section_gap">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="login_box_img">
                    <img class="img-fluid" src="{{ asset('frontend/img/login.jpg') }}" alt="">
                    <div class="hover">
                        <h4>New to StoreNex ?</h4>
                        <p>StoreNex is your one-stop e-commerce platform.</p>
                        <a class="primary-btn" href="{{ route('Customerregisterpage') }}">Create an Account</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="login_form_inner">
                    <h3>Log in to enter</h3>
                    <form class="row login_form" action="{{ route('customerlogin') }}" method="post" id="contactForm" novalidate="novalidate">
                        @csrf
                        <div class="col-md-12 form-group">
                            <input type="text" class="form-control" id="email" name="email" placeholder="Email *" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Email'" value="{{ old('email') }}">
                            @error('email') <div class="text-danger text-left">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-12 form-group">
                            <div class="password-toggle">
                                <input type="password" class="form-control" id="password" name="password" placeholder="Password *" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Password'">
                                <i class="toggle-password fas fa-eye-slash" onclick="togglePasswordVisibility()"></i>
                            </div>
                            @error('password') <div class="text-danger text-left">{{ $message }}</div> @enderror
                        </div>  
                        <div class="col-md-12 form-group">
                            <div class="creat_account">
                                <input type="checkbox" id="f-option2" name="selector">
                                <label for="f-option2">Keep me logged in</label>
                            </div>
                        </div>
                        <div class="col-md-12 form-group">
                            <button type="submit" value="submit" class="primary-btn">Log In</button>
                            <a href="{{ route('ForgotPasswordPage') }}">Forgot Password?</a>
                        </div>
                    </form>                                                                           
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    function togglePasswordVisibility() {
        var passwordInput = document.getElementById("password");
        var toggleIcon = document.querySelector(".toggle-password");

        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            toggleIcon.classList.remove("fa-eye-slash");
            toggleIcon.classList.add("fa-eye");
        } else {
            passwordInput.type = "password";
            toggleIcon.classList.remove("fa-eye");
            toggleIcon.classList.add("fa-eye-slash");
        }
    }
</script>

<!--================End Login Box Area =================--> @endsection