@extends('frontend.layouts.app')

@section('content')

<!-- Start Banner Area -->
<section class="banner-area organic-breadcrumb">
    <div class="container">
        <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
            <div class="col-first">
                <h1>Wishlist</h1>
            </div>
        </div>
    </div>
</section>
<!-- End Banner Area -->

<!--================ Wishlist Area =================-->
<section class="cart_area">
    <div class="container">
        <div class="cart_inner">
            @if($wishlistItems && count($wishlistItems) > 0)
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Product</th>
                            <th scope="col">Price</th>
                            <th scope="col">Add to Cart</th>
                            <th scope="col">Remove</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Wishlist items loop -->
                        @foreach($wishlistItems as $wishlistItem)
                        <!-- Wishlist item row -->
                        <tr>
                            <!-- Product details -->
                            <td>
                                <div class="media">
                                    <a href="{{ route('product.show', ['id' => base64_encode($wishlistItem->product_id)]) }}">
                                    <div class="d-flex">
                                        @php
                                            $images = explode(",", $wishlistItem->product->image);
                                            $lastImage = reset($images);
                                        @endphp
                                        <img style="height:100px; width:100px; border:1px solid #ccc; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);" src="{{ asset('storage/ProductIMG/' .$lastImage) }}" alt="{{ $wishlistItem->product->name }}">
                                    </div>
                                    <div class="media-body">
                                        <p>{{ $wishlistItem->product->name }}</p>
                                        </a>
                                    </div>
                                </div>
                            </td>
                            <!-- Product price -->
                            <td>
                                <h5>₹{{ number_format($wishlistItem->product->price, 2) }}</h5>
                            </td>
                            <td>
                                <!-- Link triggers the hidden form submission for adding to cart -->
                                <a class="add-to-cart-btn" style="cursor: pointer; display: inline-block; padding: 5px; border-radius: 50%;" onclick="event.preventDefault(); document.getElementById('add-to-cart-form-{{ $wishlistItem->product_id }}').submit();">
                                    <i class="ti-bag" style="color: rgb(0, 0, 0);"></i>
                                    <span class="hover-text"></span>
                                </a>
                            
                                <!-- Hidden form for adding item to cart -->
                                <form id="add-to-cart-form-{{ $wishlistItem->product_id }}" action="{{ route('cart.add', ['productId' => base64_encode($wishlistItem->product_id)]) }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </td>                            
                            <!-- Remove product from wishlist -->
                            <td>
                                <span class="remove_item_btn" data-id="{{ $wishlistItem->id }}" style="cursor: pointer; padding: 5px; border-radius: 50%;" onclick="removeFromWishlist({{ $wishlistItem->product_id }})">
                                    <i class="fas fa-trash" style="color: rgb(0, 0, 0);"></i>
                                </span>
                            </td>                            
                        </tr>
                        <!-- End of wishlist item row -->
                        @endforeach
                        <!-- End of wishlist items loop -->
                    </tbody>
                </table>
            </div>
            <!-- End of table-responsive -->
            @else
            <!-- Wishlist is empty message -->
            <div class="text-center" style="margin-top: 50px;">
                <h1 style="font-size: 36px;">YOUR WISHLIST IS CURRENTLY EMPTY.</h1>
            </div>
            <!-- End of wishlist is empty message -->
            @endif
        </div>
        <!-- End of cart_inner -->
    </div>
    <!-- End of container -->
</section>
<script>
    function removeFromWishlist(productId) {
        // Send an AJAX request to remove the product from the wishlist
        $.ajax({
            url: '{{ route('wishlist.remove') }}',
            type: 'DELETE',
            data: {
                _token: '{{ csrf_token() }}',
                product_id: productId
            },
            success: function(response) {
                // Redirect back to the previous page after successful removal
                location.reload();
            },
            error: function(xhr) {
                // Handle errors if any
                console.log(xhr.responseText);
            }
        });
        location.reload();
    }
</script>


<!--================ End Wishlist Area =================-->

@endsection
