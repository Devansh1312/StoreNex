<!DOCTYPE html>
<html lang="zxx" class="no-js">
    <head>
        <!-- Font Awesome -->
        <link rel="stylesheet" href="{{asset('plugins/fontawesome-free/css/all.min.css')}}">
        <!-- Ionicons -->
        {{-- <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css"> --}}
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-xxXdLr7uHxqOXmYLbHu7A3WUVwUqK6/vFAe7wfsyNTwC1Rcr73pBHT1VdrJwz+OYx+FHkCt0gNQY6GDZD6U+qQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <!-- jQuery -->
        <script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
        <!-- jQuery UI 1.11.4 -->
        <script src="{{asset('plugins/jquery-ui/jquery-ui.min.js')}}"></script>
        <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
        <script>
            $.widget.bridge('uibutton', $.ui.button)
        </script>
        <!-- Bootstrap 4 -->
        <script src="{{asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
        <!-- ChartJS -->
        <script src="{{asset('plugins/chart.js/Chart.min.js')}}"></script>
        <!-- Sparkline -->
        <script src="{{asset('plugins/sparklines/sparkline.js')}}"></script>
        <!-- JQVMap -->
        <script src="{{asset('plugins/jqvmap/jquery.vmap.min.js')}}"></script>
        <script src="{{asset('plugins/jqvmap/maps/jquery.vmap.usa.js')}}"></script>
        <!-- jQuery Knob Chart -->
        <script src="{{asset('plugins/jquery-knob/jquery.knob.min.js')}}"></script>
        <!-- Add these to the head section of your layout file -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastr@2.1.4/dist/css/toastr.min.css">
        <script src="https://cdn.jsdelivr.net/npm/toastr@2.1.4"></script>
        <!-- Sweat Alert -->
        <script src="{{asset('plugins/sweetalert2/sweetalert2.min.js')}}"></script>
        <link rel="stylesheet" href="{{asset('plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css')}}">
        <link rel="stylesheet" href="{{asset('plugins/toastr/toastr.min.css')}}">
        <script src="{{asset('plugins/toastr/toastr.min.js')}}"></script>
        <script>
            // Add this script block to show success or error messages
            $(document).ready(function() {
                @if(Session::has('success'))
                toastr.options = {
                    "progressBar": true,
                    "closeButton": true,
                }
                toastr.success("{{ Session::get('success') }}", 'Success!', {
                    timeOut: 10000
                });
                @endif

                @if(Session::has('error'))
                toastr.options = {
                    "progressBar": true,
                    "closeButton": true,
                }
                toastr.error("{{ Session::get('error') }}", 'Error!', {
                    timeOut: 10000
                });
                @endif

                @if(Session::has('warning'))
                toastr.options = {
                    "progressBar": true,
                    "closeButton": true,
                }
                toastr.warning("{{ Session::get('warning') }}", 'Warning!', {
                    timeOut: 10000
                });
                @endif

                @if(Session::has('info'))
                toastr.options = {
                    "progressBar": true,
                    "closeButton": true,
                }
                toastr.info("{{ Session::get('info') }}", 'Info!', {
                    timeOut: 10000
                });
                @endif

                @if(Session::has('confirmation'))
                toastr.options = {
                    "progressBar": true,
                    "closeButton": true,
                }
                toastr.info("{{ Session::get('confirmation') }}", 'Confirmation!', {
                    timeOut: 10000
                });
                @endif
            });
        </script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <!-- Mobile Specific Meta -->
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <!-- Favicon-->
        <link rel="shortcut icon" href="img/fav.png">
        <!-- Author Meta -->
        <meta name="author" content="CodePixar">
        <!-- Meta Description -->
        <meta name="description" content="">
        <!-- Meta Keyword -->
        <meta name="keywords" content="">
        <!-- meta character set -->
        <meta charset="UTF-8">
        
        <!-- CSS -->
        <link rel="stylesheet" href="{{ asset('frontend/css/linearicons.css') }}">
        <link rel="stylesheet" href="{{ asset('frontend/css/font-awesome.min.css') }}">
        <link rel="stylesheet" href="{{ asset('frontend/css/themify-icons.css') }}">
        <link rel="stylesheet" href="{{ asset('frontend/css/bootstrap.css') }}">
        <link rel="stylesheet" href="{{ asset('frontend/css/owl.carousel.css') }}">
        <link rel="stylesheet" href="{{ asset('frontend/css/nice-select.css') }}">
        <link rel="stylesheet" href="{{ asset('frontend/css/nouislider.min.css') }}">
        <link rel="stylesheet" href="{{ asset('frontend/css/ion.rangeSlider.css') }}" />
        <link rel="stylesheet" href="{{ asset('frontend/css/ion.rangeSlider.skinFlat.css') }}" />
        <link rel="stylesheet" href="{{ asset('frontend/css/magnific-popup.css') }}">
        <link rel="stylesheet" href="{{ asset('frontend/css/main.css') }}">
    </head>
    <body>
        <!-- Start Header Area -->
        <header class="header_area sticky-header">
            <div class="main_menu">
                <nav class="navbar navbar-expand-lg navbar-light main_box">
                    <div class="container">
                        <!-- Brand and toggle get grouped for better mobile display -->
                        <a class="navbar-brand logo_h" href="{{ route('welcome') }}">
                            <img src="{{ asset('storage/SystemSetting/systemlogo.png') }}" alt="Logo">
                        </a>
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <!-- Collect the nav links, forms, and other content for toggling -->
                        <div class="collapse navbar-collapse offset" id="navbarSupportedContent">
                            <ul class="nav navbar-nav menu_nav ml-auto">
                                <li class="nav-item {{ Request::is('/') ? 'active' : '' }}">
                                    <a class="nav-link" href="{{ route('welcome') }}">Home</a>
                                </li>
                                <li class="nav-item {{ Request::is('AllProducts*') ? 'active' : '' }}">
                                    <a class="nav-link" href="{{ route('showAllProducts') }}">Products</a>
                                </li>
                                {{-- ////////////////////// --}}
                                <li class="nav-item submenu dropdown {{ Request::is('About-Us') ? 'active' : '' }}">
                                    <a class="nav-link " href="{{ route('AboutUs') }}">About Us</a>
                                </li>
                                <li class="nav-item submenu dropdown {{ Request::is('FAQ') ? 'active' : '' }}">
                                    <a class="nav-link " href="{{ route('FAQ') }}">FAQ</a>
                                </li>
                                <li class="nav-item submenu dropdown {{ Request::is('Contact-Us') ? 'active' : '' }}">
                                    <a class="nav-link " href="{{ route('ContactUs') }}">Contact Us</a>
                                </li>
                                <li class="nav-item submenu dropdown {{ Request::is('Terms&Condition') ? 'active' : '' }}">
                                    <a class="nav-link " href="{{ route('TermsAndCondition') }}">Terms & Condition</a>
                                </li> 
                                    @if(auth()->check())
                                    <li class="nav-item submenu dropdown {{ Request::is('cart*') ? 'active' : '' }}">
                                        @php
                                            // Retrieve total quantity of items in the cart for the current user
                                            $totalItemsInCart = auth()->user()->cart()->sum('quantity');
                                        @endphp
                                        <a href="{{ route('cart') }}" class="nav-link" data-toggle="popover" data-content="Total Items in Cart: {{ $totalItemsInCart }}">
                                            <span class="ti-bag" style="position: relative;">
                                                @if ($totalItemsInCart > 0)
                                                    <span class="total-items-in-cart" style="position: absolute; top: -20px; right: -20px; color: #710468; border-radius: 50%; padding: 10px; font-size: 15px;">{{ $totalItemsInCart }}</span>
                                                @endif
                                            </span>
                                        </a>
                                    </li>
                                    <li class="nav-item submenu dropdown {{ Request::is('wishlist*') ? 'active' : '' }}">
                                        @php
                                            // Retrieve total quantity of items in the wishlist for the current user
                                            $totalItemsInWishlist = auth()->user()->wishlists()->count();
                                        @endphp
                                        <a href="{{ route('wishlist') }}" class="nav-link" data-toggle="popover" data-content="Total Items in Wishlist: {{ $totalItemsInWishlist }}">
                                            <span class="ti-heart" style="position: relative;">
                                                @if ($totalItemsInWishlist > 0)
                                                    <span class="total-items-in-wishlist" style="position: absolute; top: -20px; right: -20px; color: #710468; border-radius: 50%; padding: 10px; font-size: 15px;">{{ $totalItemsInWishlist }}</span>
                                                @endif
                                            </span>
                                        </a>
                                    </li>                                    
                                    <!-- User is authenticated, show user dropdown -->
                                    <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle {{ Request::is('Profile', 'order-history') ? 'active' : '' }}" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="position: relative; cursor: pointer;">
                                            <span class="lnr lnr-user"></span> {{ auth()->user()->name }}
                                        </a>                                        
                                        <div class="dropdown-menu" aria-labelledby="userDropdown" style="min-width: 150px; padding: 10px; border-radius: 5px; box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);">
                                            <!-- You can add more user-related options here -->
                                            <a class="dropdown-item" href="{{route('Profile')}}" style="color: #333;">Profile</a>
                                            <div class="dropdown-divider" style="margin: 5px;"></div>
                                            <a class="dropdown-item" href="{{route('OrderHistory')}}" style="color: #333;">Order History</a>
                                            <div class="dropdown-divider" style="margin: 5px;"></div>
                                            <form id="logoutForm" action="{{ route('Customerlogout') }}" method="POST"> 
                                                @csrf 
                                                <button type="submit" class="dropdown-item" style="color: #333; background-color: #f8f9fa; border: none;">Logout</button>
                                            </form>
                                        </div>
                                    </li> 
                                @else
                                <!-- User is not authenticated, show login icon -->
                                <li class="nav-item {{ Request::is('Customer-Register','Customer-Login') ? 'active' : '' }}">
                                    <a class="nav-link" href="{{ route('customerloginpage') }}">
                                        <span class="lnr lnr-enter"></span> Login
                                        <!-- You can use any other icon or text here -->
                                    </a>
                                </li> @endif 
                            </ul>
                            <ul class="nav navbar-nav navbar-right">
                                <li class="nav-item">
                                    <button class="search"><span style="color: rgb(60, 0, 116);" class="lnr lnr-magnifier" id="search"></span></button>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </div>
            <div class="search_input" id="search_input_box">
                <div class="container">
                    <form action="{{ route('showAllProducts') }}" class="d-flex justify-content-between" method="GET">
                        <input type="text" name="s" class="form-control" id="search_input" placeholder="Search Here" 
                               @if(isset($request->s)) value="{{ $request->s }}" @endif>
                        <button type="submit" class="btn"></button>
                        <span class="lnr lnr-cross" id="close_search" title="Close Search"></span>
                    </form>
                </div>                                       
            </div>
        </header>
        <script>
            $(document).ready(function() {
                // Handle category dropdown click event
                $('.category-dropdown').on('click', function() {
                    // Get the category ID
                    var categoryId = $(this).data('category-id');
                    // Fetch subcategories for the clicked category
                    $.ajax({
                        url: '/fetch-subcategories/' + categoryId, // Adjust the URL to your route
                        method: 'GET',
                        success: function(data) {
                            // Update the subcategory dropdown with the fetched data
                            $('#subcategory-dropdown').html(data);
                        },
                        error: function(error) {
                            console.log(error);
                        }
                    });
                });
            });
        </script>