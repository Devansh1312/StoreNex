@extends('frontend.layouts.app')

@section('content')
<!-- Sweat Alert -->
<script src="{{asset('plugins/sweetalert2/sweetalert2.min.js')}}"></script>
<link rel="stylesheet" href="{{asset('plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css')}}">
<link rel="stylesheet" href="{{asset('plugins/toastr/toastr.min.css')}}">
<script src="{{asset('plugins/toastr/toastr.min.js')}}"></script>
<style>
    .product-images img {
            max-width: 100%;
            height: auto;
            max-height: 400px;
        }
    .dealsofweek {
        max-width: 80px;
        max-height: 70px;
    }
   /* Hide Owl Carousel controls for the banner section */
   .banner-area .owl-controls {
        display: none !important;
    }

    .icon_btn.purple-heart {
        font-size: 30px;
        color: purple;
        margin-left: 10px;
    }

</style>

<!-- Start Banner Area -->
<section class="banner-area organic-breadcrumb">
    <div class="container">
        <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
            <div class="col-first">
                <h1>{{ $product->subcategory->name }}</h1>
            </div>
        </div>
    </div>
</section>
<!-- End Banner Area -->
<!--================Single Product Area =================-->
<div class="product_image_area">
    <div class="container">
        <div class="row s_product_inner">
            <div class="col-lg-6 product-images"> <!-- Add product-images class here -->
                @if($product->image)
                    @php
                        $images = explode(',', $product->image);
                        $imageCount = count($images);
                    @endphp
            
                    @if($imageCount > 1)
                        <div class="s_Product_carousel">
                            @foreach($images as $image)
                                <div class="single-prd-item">
                                    <img class="img-fluid" src="{{ asset('storage/ProductIMG/'.$image) }}" alt="{{ $product->name }}">
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="single-prd-item">
                            <img class="img-fluid" src="{{ asset('storage/ProductIMG/'.$images[0]) }}" alt="{{ $product->name }}">
                        </div>
                    @endif
                @endif
            </div>            
            <div class="col-lg-5 offset-lg-1">
                <div class="">
                    <h3>{{ $product->name }}</h3>
                    <h2>₹{{ number_format($product->price, 2) }}</h2>
                    <ul class="list">
                        <li><b style="color: rgb(29, 22, 22)">Category:- </b> {{ $product->subcategory->name ?? 'N/A' }}</li>
                        <li><b style="color: rgb(29, 22, 22)">Availability:- </b> In Stock</li> <!-- Adjust based on actual availability -->
                    </ul>
                    <ul>
                        <li>
                            {!! $product->description !!}
                        </li>
                    </ul>
                    <div style="margin-top: 40px;" class="card_area d-flex align-items-center">
                        <!-- Add to Cart button -->
                        <form action="{{ route('cart.add', ['productId' => base64_encode($product->id)]) }}" method="POST">
                            @csrf
                            <button type="submit" class="primary-btn">Add to Cart</button>
                        </form>
                        <!-- Add to Wishlist or Remove from Wishlist Button -->
                        @if(auth()->check()) <!-- Check if user is logged in -->
                            @php
                                $isWishlisted = Auth::user()->wishlists()->where('product_id', $product->id)->exists();
                            @endphp
                            @if($isWishlisted)
                                <form action="{{ route('wishlist.remove') }}" method="POST" id="removeWishlistForm{{$product->id}}">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <a class="icon_btn" href="javascript:;" onclick="document.getElementById('removeWishlistForm{{$product->id}}').submit();" style="font-size: 30px; color: purple; margin-left:10px;">
                                        <i class="fas fa-heart"></i> <!-- Solid icon -->
                                    </a>
                                </form>
                            @else
                                <form action="{{ route('wishlist.add') }}" method="POST" id="addWishlistForm{{$product->id}}">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <a class="icon_btn" href="javascript:;" onclick="document.getElementById('addWishlistForm{{$product->id}}').submit();" style="font-size: 30px; margin-left:10px;">
                                        <i class="lnr lnr-heart"></i> <!-- Regular icon -->
                                    </a>
                                </form>
                            @endif
                        @else <!-- If user is not authenticated -->
                            <a class="icon_btn" href="{{ route('guestuser') }}" style="font-size: 30px; margin-left:10px;">
                                <i class="lnr lnr-heart"></i> <!-- Regular icon -->
                            </a>
                        @endif
                    </div>                    
                </div>
            </div>
        </div>
    </div>
</div>
<!--================End Single Product Area =================-->

<div style="padding: 30px">

</div>
<!-- Related Product Area -->
<section class="related-product-area section_gap_bottom">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 text-center">
                <div class="section-title">
                    <h1>Related Products</h1>
                    <p>StoreNex is your one-stop e-commerce platform, offering a diverse range of products from various sellers.</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-9">
                <div class="row">
                    @if ($relatedProducts->isEmpty())
                    <div class="alert alert-info mt-4" role="alert">
                        Relevent Products Comming Soon..
                    </div>
                    <!-- Related products code here -->
                    @else
                    <!-- Loop through related products -->
                    @foreach($relatedProducts as $relatedProduct)
                    <div class="col-lg-4 col-md-4 col-sm-6 mb-20">
                        <div class="single-related-product d-flex">
                            <a href="{{ route('product.show', ['id' => base64_encode($relatedProduct->id)]) }}">
                                @php
                                $images = explode(",", $relatedProduct->image);
                                $lastImage = reset($images);
                                @endphp
                                <img class="dealsofweek" src="{{ asset('storage/ProductIMG/' . $lastImage) }}" alt="{{ $relatedProduct->name }}">
                            </a>
                            <div class="desc">
                                <a href="{{ route('product.show', ['id' => base64_encode($relatedProduct->id)]) }}" class="title">{{ $relatedProduct->name }}
                                <div class="price">
                                    <h6>₹{{ number_format($relatedProduct->price, 2) }}</h6>
                                    @if($relatedProduct->discounted_price)
                                    <h6 class="l-through">${{ $relatedProduct->discounted_price }}</h6>
                                    @endif
                                </div>
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    <!-- End loop -->
                    @endif
                </div>
            </div>
            <div class="col-lg-3">
                <div class="ctg-right">
                    <a href="#" target="_blank">
                        <img class="img-fluid d-block mx-auto" src="{{asset('frontend/img/category/c5.jpg')}}" alt="">
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Related Product Area -->
@endsection


