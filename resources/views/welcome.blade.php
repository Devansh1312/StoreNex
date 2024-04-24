@extends('frontend.layouts.app')

@section('content')
<!-- Add these to the head section of your layout file -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastr@2.1.4/dist/css/toastr.min.css">
<script src="https://cdn.jsdelivr.net/npm/toastr@2.1.4"></script>
<!-- Sweat Alert -->
<script src="{{asset('plugins/sweetalert2/sweetalert2.min.js')}}"></script>
<link rel="stylesheet" href="{{asset('plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css')}}">
<link rel="stylesheet" href="{{asset('plugins/toastr/toastr.min.css')}}">
<script src="{{asset('plugins/toastr/toastr.min.js')}}"></script>

<style>
    body {
        /* background-color: #cfeaf1; */
    }

    .col-lg-8.col-md-8 img {
        width: 477px;
        height: 225px;
        object-fit: cover;
        /* Stretch or compress image while maintaining aspect ratio */
    }

    /* For col-lg-4 col-md-4 */
    .col-lg-4.col-md-4 .single-deal img {
        width: 262px;
        height: 225px;
        object-fit: cover;
        /* Stretch or compress image while maintaining aspect ratio */
    }

    .banner-img img {
        width: 100%;
        height: 400px;
        /* Fixed height to ensure consistency */
        object-fit: contain;
        /* Ensures the entire image fits within the box, might leave some empty space */
        /* background-color: #f4f4f4;  */
    }

    /* .single-deal {
      width: 200px;
      height: 200px;
   } */

    .single-product img {
        max-width: 200px;
        max-height: 200px;
    }

    .product-details h6 {
        min-height: 40px;
        /* Set a fixed height for product name container */
    }

    .dealsofweek {
        max-width: 80px;
        max-height: 70px;
    }

    /* .category-area .single-deal img {
      max-width: 100%;
      height: 200px;
      object-fit: cover;
   } */
    /* Hide Owl Carousel controls for the banner section */
    .banner-area .owl-controls {
        display: none !important;
    }
</style>

<!-- start banner Area -->
<section class="banner-area">
    <div class="container">
        <div class="row fullscreen align-items-center justify-content-start">
            <div class="col-lg-12">
                <div class="active-banner-slider">
                    <!-- Start loop for each product -->
                    @foreach($bannerproduct as $product)
                        <div class="row single-slide align-items-center d-flex">
                            <a href="{{ route('subcategory.products', ['id' => base64_encode($product->id)]) }}">
                            <div class="col-12 col-sm-6 col-md-5">
                                <div class="banner-content">
                                    <h1>{{ $product->name }}
                                        <br>Collection!
                                    </h1>
                                    <div class="add-bag d-flex align-items-center">
                                        <a class="add-btn" href="{{ route('subcategory.products', ['id' =>base64_encode($product->id)]) }}">
                                            <span class="lnr lnr-cross"></span>
                                        </a>
                                        <span class="add-text text-uppercase">View More..</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-md-7">
                                <div class="banner-img">

                                    <img class="img-fluid"
                                            src="{{ asset('storage/subcategory_images/' . $product->image) }}"
                                            alt="{{ $product->name }}">
                                    </a>
                                </div>
                            </div>
                        </a>

                        </div>
                    @endforeach
                    <!-- End loop -->
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End banner Area -->


<!-- start features Area -->
<section class="features-area section_gap">
    <div class="container">
        <div class="row features-inner">
            <!-- single features -->
            <!-- Loop through features data -->
            @foreach($blogs as $blogs)
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="single-features">
                    <div class="f-icon">
                        <img src="{{ asset('storage/HomepageBlogImg/' . $blogs->image) }}" alt="{{ $blogs->title }}">
                    </div>
                    <h6>{{ $blogs->title }}</h6>
                    <p>{{ $blogs->{'sub-title'} }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
<!-- end features Area -->

<!-- Start category Area -->
<section class="category-area">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-12">
                <div class="row">
                    @foreach($category as $key => $category)
                    @if($key == 0)
                    <div class="col-lg-8 col-md-8">
                        @elseif($key == 1)
                        <div class="col-lg-4 col-md-4">
                            @elseif($key == 2)
                            <div class="col-lg-4 col-md-4">
                                @elseif($key == 3)
                                <div class="col-lg-8 col-md-8">
                                    @endif
                                    <div class="single-deal">
                                        <div class="overlay"></div>
                                        <img class="img-fluid w-100"
                                            src="{{ asset('storage/CategoryIMG/' . $category->image) }}"
                                            alt="{{ $category->name }}">
                                        <a href="{{ asset('storage/CategoryIMG/' . $category->image) }}"
                                            class="img-pop-up" target="_blank">
                                            <div class="deal-details">
                                                <h6 class="deal-title">{{ $category->name }}</h6>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="single-deal">
                                <div class="overlay"></div>
                                <img style="height: 480px; object-fit: cover;" class="img-fluid w-100" src="{{asset('frontend/img/category/c5.jpg')}}" alt="">
                            </div>
                        </div>
                    </div>
                </div>
</section>
<!-- End category Area -->


<!-- Product and Related Product Areas -->
<section class="owl-carousel active-product-area section_gap">
    <!-- Latest Products -->
    <div class="single-product-slider">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-12 col-md-12 text-center"> <!-- Changed col-lg-6 to col-lg-12 and col-md-6 to col-md-12 for full width on mobile -->
                    <div class="section-title">
                        <h1>Latest Products</h1>
                        <p>StoreNex is your one-stop e-commerce platform, offering a diverse range of products from various sellers.</p>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center"> <!-- Added justify-content-center to center the content -->
                <!-- Loop through latest products -->
                @foreach($latestproduct as $product)
                <div class="col-lg-3 col-md-6 col-sm-6"> <!-- Added col-sm-6 to ensure proper alignment on smaller screens -->
                    <div class="single-product justify-content-center">
                        @php
                        $images = explode(",", $product->image);
                        $lastImage = reset($images);
                        @endphp
                        <a href="{{ route('product.show', ['id' =>base64_encode($product->id)]) }}">
                            <img class="img-fluid" src="{{ asset('storage/ProductIMG/' . $lastImage) }}"
                                alt="{{ $product->name }}">
                            <div class="product-details">
                                <h6>{{ $product->name }}</h6>
                        </a>
                        <div class="price">
                            <h6>₹{{ number_format($product->price, 2) }}</h6>
                            @if($product->discounted_price)
                            <h6 class="l-through">₹{{ $product->discounted_price }}</h6>
                            @endif
                        </div>
                        <div class="prd-bottom">
                            <a class="social-info add-to-cart-btn" onclick="event.preventDefault(); document.getElementById('add-to-cart-form-{{ $product->id }}').submit();"> <!-- Anchor tag with class add-to-cart-btn -->
                                <form id="add-to-cart-form-{{ $product->id }}" action="{{ route('cart.add', ['productId' => base64_encode($product->id)]) }}" method="POST" style="display: none;"> <!-- Hidden form -->
                                    @csrf
                                </form>
                                <span class="ti-bag"></span>
                                <p class="hover-text">add to bag</p>
                            </a> 
                            <a href="{{ route('product.show', ['id' => base64_encode($product->id)]) }}" class="social-info">
                                <span class="lnr lnr-move"></span>
                                <p class="hover-text">view more</p>
                            </a>
                            <a class="social-info add-to-wishlist-btn" onclick="toggleWishlist({{ $product->id }})">
                                <span class="lnr lnr-heart"></span>
                                <p class="hover-text">Wishlist</p>
                            </a>
                            @if(auth()->check())
                                @php
                                    $isWishlisted = Auth::user()->wishlists()->where('product_id', $product->id)->exists();
                                @endphp
                                <form action="{{ $isWishlisted ? route('wishlist.remove') : route('wishlist.add') }}" method="POST" id="toggleWishlistForm{{$product->id}}" style="display: none;">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    @if($isWishlisted)
                                        @method('DELETE')
                                    @endif
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            <!-- End loop -->
        </div>
    </div>
    </div>

    <!-- Coming Products -->
    <div class="single-product-slider">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-12 col-md-12 text-center"> <!-- Changed col-lg-6 to col-lg-12 and col-md-6 to col-md-12 for full width on mobile -->
                    <div class="section-title">
                        <h1>Featured Products</h1>
                        <p>StoreNex is your one-stop e-commerce platform, offering a diverse range of products from various sellers.</p>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center"> <!-- Added justify-content-center to center the content -->
                <!-- Loop through coming products -->
                @foreach($commingproduct as $product)
                <div class="col-lg-3 col-md-6 col-sm-6"> <!-- Added col-sm-6 to ensure proper alignment on smaller screens -->
                    <div class="single-product justify-content-center">
                        @php
                        $images = explode(",", $product->image);
                        $lastImage = reset($images);
                        @endphp
                        <a href="{{ route('product.show', ['id' => base64_encode($product->id)]) }}">
                            <img class="img-fluid" src="{{ asset('storage/ProductIMG/' . $lastImage) }}"
                                alt="{{ $product->name }}">
                            <div class="product-details">
                                <h6>{{ $product->name }}</h6>
                        </a>
                        <div class="price">
                            <h6>₹{{ number_format($product->price, 2) }}</h6>
                            @if($product->discounted_price)
                            <h6 class="l-through">₹{{ $product->discounted_price }}</h6>
                            @endif
                        </div>
                        <div class="prd-bottom">
                            <a href="{{ route('cart.add', ['productId' => base64_encode($product->id)]) }}" class="social-info" onclick="event.preventDefault(); document.getElementById('add-to-cart-form').submit();">
                                <span class="ti-bag"></span>
                                <p class="hover-text">add to bag</p>
                            </a> 
                            <form id="add-to-cart-form" action="{{ route('cart.add', ['productId' => base64_encode($product->id)]) }}" method="POST" style="display: none;">
                                @csrf
                                <button type="submit" class="hidden-submit"></button>
                            </form> 
                            <a href="{{ route('product.show', ['id' => base64_encode($product->id)]) }}" class="social-info">
                                <span class="lnr lnr-move"></span>
                                <p class="hover-text">view more</p>
                            </a>
                            <a class="social-info add-to-wishlist-btn" onclick="toggleWishlist({{ $product->id }})">
                                <span class="lnr lnr-heart"></span>
                                <p class="hover-text">Wishlist</p>
                            </a>
                            @if(auth()->check())
                                @php
                                    $isWishlisted = Auth::user()->wishlists()->where('product_id', $product->id)->exists();
                                @endphp
                                <form action="{{ $isWishlisted ? route('wishlist.remove') : route('wishlist.add') }}" method="POST" id="toggleWishlistForm{{$product->id}}" style="display: none;">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    @if($isWishlisted)
                                        @method('DELETE')
                                    @endif
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            <!-- End loop -->
        </div>
    </div>
</section>

<!-- Related Product Area -->
<section class="related-product-area section_gap_bottom">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 text-center">
                <div class="section-title">
                    <h1>Best Selling Products</h1>
                    <p>StoreNex is your one-stop e-commerce platform, offering a diverse range of products from various sellers.</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-9">
                <div class="row">
                    <!-- Loop through deals of the week -->
                    @foreach($products as $product)
                    <div class="col-lg-4 col-md-4 col-sm-6 mb-20">
                        <div class="single-related-product d-flex">
                            <a href="{{ route('product.show', ['id' => base64_encode($product->id)]) }}">
                                @php
                                $images = explode(",", $product->image);
                                $lastImage = reset($images);
                                @endphp
                                <img class="dealsofweek" src="{{ asset('storage/ProductIMG/' . $lastImage) }}"
                                    alt="{{ $product->name }}">
                            </a>
                            <div class="desc">
                                <a href="{{ route('product.show', ['id' => base64_encode($product->id)]) }}" class="title">{{
                                    $product->name }}
                                    <div class="price">
                                        <h6>₹{{ number_format($product->price, 2) }}</h6>
                                        @if($product->discounted_price)
                                        <h6 class="l-through">${{ $product->discounted_price }}</h6>
                                        @endif
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    <!-- End loop -->
                </div>
            </div>
            <div class="col-lg-3">
                <div class="ctg-right">
                    <img class="img-fluid d-block mx-auto" src="{{asset('frontend/img/category/c5.jpg')}}" alt="">
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    function toggleWishlist(productId) {
        var form = document.getElementById('toggleWishlistForm' + productId);
        form.submit();
    }
</script>
<!-- End Related Product Area -->

@endsection