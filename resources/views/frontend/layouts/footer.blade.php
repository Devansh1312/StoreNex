<footer class="footer-area">
    <div class="container-fluid">
        <div class="row">
            <!-- About Us -->
            <div class="col-12 col-sm-6 col-md-3">
                <div style="margin-left:10px;" class="single-footer-widget">
                    <h6>Contact Information</h6>
                    @if(isset($SystemSetting))
                    <p>Email: {{ $SystemSetting->email }}</p>
                    <p>Phone: +91 {{ $SystemSetting->phone }}</p>
                    <div class="footer-social d-flex align-items-center">
                        @if($SystemSetting->facebook)<a href="{{ $SystemSetting->facebook }}"><i
                                class="fa fa-facebook"></i></a>@endif
                        @if($SystemSetting->twitter)<a href="{{ $SystemSetting->twitter }}"><i
                                class="fa fa-twitter"></i></a>@endif
                        @if($SystemSetting->instagram)<a href="{{ $SystemSetting->instagram }}"><i
                                class="fa fa-instagram"></i></a>@endif
                        @if($SystemSetting->linkedin)<a href="{{ $SystemSetting->linkedin }}"><i
                                class="fa fa-linkedin"></i></a>@endif
                    </div>
                    @endif
                </div>
            </div>

            <!-- Newsletter -->
            <div class="col-12 col-sm-6 col-md-5">
                <div class="single-footer-widget">
                    <h6>Newsletter</h6>
                    <p>Stay updated with our latest News</p>
                    <p>Coming Soon.....</p>
                    <div class="" id="mc_embed_signup">
                         <!-- <form target="_blank" novalidate="true" action="#" method="get" class="form-inline">
                            <div class="d-flex flex-row">
                                <input class="form-control" name="EMAIL" placeholder="Enter Email"
                                    onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter Email '"
                                    required="" type="email">
                                <button class="click-btn btn btn-default">
                                    <i class="fa fa-long-arrow-right" aria-hidden="true"></i>
                                </button>
                                <div style="position: absolute; left: -5000px;">
                                    <input name="b_36c4fd991d266f23781ded980_aefe40901a" tabindex="-1" value=""
                                        type="text">
                                </div>
                            </div>
                            <div class="info"></div>
                        </form>-->
                    </div>
                </div>
            </div>

            <!-- Contact Information and Social Links -->
            <div class="col-12 col-md-4">
                <div class="single-footer-widget">
                    <h6>Address</h6>
                    @if(isset($SystemSetting))
                    <p>{{ $SystemSetting->address }}</p>
                    <p>Email: {{ $SystemSetting->email }}</p>
                    <p>Phone: +91 {{ $SystemSetting->phone }}</p>
                    <div class="footer-social d-flex align-items-center">
                        @if($SystemSetting->facebook)<a href="{{ $SystemSetting->facebook }}"><i
                                class="fa fa-facebook"></i></a>@endif
                        @if($SystemSetting->twitter)<a href="{{ $SystemSetting->twitter }}"><i
                                class="fa fa-twitter"></i></a>@endif
                        @if($SystemSetting->instagram)<a href="{{ $SystemSetting->instagram }}"><i
                                class="fa fa-instagram"></i></a>@endif
                        @if($SystemSetting->linkedin)<a href="{{ $SystemSetting->linkedin }}"><i
                                class="fa fa-linkedin"></i></a>@endif
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Copyright Information -->
        <div class="footer-bottom d-flex justify-content-center align-items-center flex-wrap">
            <p class="footer-text m-0">Copyright &copy; <script>
                    document.write(new Date().getFullYear());
                </script> All rights reserved <i class="fa fa-heart-o"
                    aria-hidden="true"></i> by <a href="https://redsparkinfo.com/" target="_blank">Redspark
                    Technologies</a></p>
        </div>
    </div>
</footer>

<!-- End footer Area -->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCjCGmQ0Uq4exrzdcL6rvxywDDOvfAu6eE"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"
    integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4"
    crossorigin="anonymous">
</script>
<link rel="stylesheet" href="{{ asset('frontend/css/font-awesome.min.css') }}">

<script src="{{ asset('frontend/js/vendor/bootstrap.min.js') }}"></script>
<script src="{{ asset('frontend/js/vendor/jquery-2.2.4.min.js') }}"></script>
<script src="{{ asset('frontend/js/jquery.ajaxchimp.min.js') }}"></script>
<script src="{{ asset('frontend/js/jquery.nice-select.min.js') }}"></script>
<script src="{{ asset('frontend/js/jquery.sticky.js') }}"></script>
<script src="{{ asset('frontend/js/nouislider.min.js') }}"></script>
<script src="{{ asset('frontend/js/countdown.js') }}"></script>
<script src="{{ asset('frontend/js/jquery.magnific-popup.min.js') }}"></script>
<script src="{{ asset('frontend/js/owl.carousel.min.js') }}"></script>
<!--gmaps Js-->
<script src="{{ asset('frontend/js/gmaps.min.js') }}"></script>
<script src="{{ asset('frontend/js/main.js') }}"></script>
<!-- Sweat Alert -->
<script src="{{asset('plugins/sweetalert2/sweetalert2.min.js')}}"></script>
<link rel="stylesheet" href="{{asset('plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css')}}">
<link rel="stylesheet" href="{{asset('plugins/toastr/toastr.min.css')}}">
<script src="{{asset('plugins/toastr/toastr.min.js')}}"></script>
</body>
</html>