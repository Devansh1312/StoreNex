<!-- productListingPage.blade.php -->
@extends('frontend.layouts.app')

@section('content')
@php
    use App\Models\Product;
@endphp
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- jQuery UI -->
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>

{{-- Sort Product Script --}}
<script>
    function sortProducts(value) {
    var currentUrl = window.location.href;

    // Extract existing parameters from the URL
    var urlParams = new URLSearchParams(window.location.search);

    // Update the 'sort' parameter with the selected value
    urlParams.set('sort', value);

    // Construct the new URL with existing parameters and the updated 'sort' parameter
    var newUrl = window.location.pathname + '?' + urlParams.toString();

    // Redirect to the new URL
    window.location.href = newUrl;
}

</script>

<!-- jQuery UI CSS -->
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

<style>
    .filter-buttons {
        display: flex;
        justify-content: space-between;
        margin-top: 10px;
    }

    .primary-btn {
        height: 40px;
        width: 100px;
        justify-content: center;
        font-size: 13px; /* Adjust the font size as needed */
        text-align: center; /* Center-align the text */
        line-height: 50px; /* Vertically center the text */
        border: none;
        background-color: #007bff; /* Change the color as needed */
        color: #ffffff; /* Change the color as needed */
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .primary-btn:hover {
        background-color: #0056b3; /* Change the color as needed */
    }

    .apply-filter-btn, .clear-filter-btn {
        width: calc(50% - 5px); /* Adjust the width as needed */
        display: inline-block; /* This ensures that the button respects the text-align property */
        text-align: center; /* Ensures text is centered horizontally */
        padding: 10px 0; /* Adjust vertical padding as needed */
        /* Optional: if your button's text is single-line and you prefer a line-height approach */
        line-height: 20px; /* Adjust according to your button's height to center the text vertically */
        vertical-align: middle; /* Helps align inline or inline-block elements */
    }

    .single-product {
    box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.1);
    transition: box-shadow 0.3s ease-in-out;
    display: flex;
    flex-direction: column; /* Ensures content is stretched vertically */
}

.single-product img {
    width: 100%; /* Adjust as needed */
    height: auto; /* Set height to auto initially */
    max-height: 260px; /* Limit maximum height to 400px */
    object-fit: cover; /* This ensures the image covers the set height without distortion */
}

.product-details {
    padding: 10px;
    flex-grow: 1; /* Makes sure it fills the available space */
    display: flex;
    flex-direction: column; /* New line */
}

.product-details h6 {
    height: 3em; /* Example fixed height */
    overflow: hidden; /* Hides overflow text */
    margin-bottom: auto; /* Pushes everything else to the bottom */
}

</style>

<!-- Start Banner Area -->
<section class="banner-area organic-breadcrumb">
    <div class="container">
        <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
            <div class="col-first">
                <h1>{{ $subcategory->name }}</h1>
            </div>
        </div>
    </div>
</section>
<!-- End Banner Area -->

<div class="container">
    <div class="row">
        <div class="col-xl-3 col-lg-4 col-md-5">
            <div class="sidebar-categories">
                <div class="head">Browse Categories</div>
                <ul class="main-categories">
                    @foreach($categories as $category)
                        <li class="main-nav-list">
                            <a data-toggle="collapse" href="#category{{ $category->id }}" aria-expanded="false" aria-controls="category{{ $category->id }}">
                                <span class="lnr lnr-arrow-right"></span>{{ $category->name }}<span class="number">({{ $category->subcategories->count() }})</span>
                            </a>
                            <ul class="collapse" id="category{{ $category->id }}" data-toggle="collapse" aria-expanded="false" aria-controls="category{{ $category->id }}">
                                @foreach($category->subcategories as $subcategory)
                                    @php
                                        $subcategoryId = $subcategory->id;
                                        $filteredProductsCount = Product::where('subcategory_id', $subcategoryId);

                                        // Apply price filter if provided
                                        if ($request->has('min_price') && $request->has('max_price')) {
                                            $minPrice = $request->input('min_price');
                                            $maxPrice = $request->input('max_price');
                                            $filteredProductsCount->whereBetween('price', [$minPrice, $maxPrice]);
                                        }

                                        // Add other filters if needed

                                        $count = $filteredProductsCount->count();
                                        
                                        // Generate URL for subcategory with current filter parameters
                                        $subcategoryUrl = route('subcategory.products', ['id' => base64_encode($subcategory->id)]) . '?' . http_build_query($request->query());
                                    @endphp
                                    <li class="main-nav-list child">
                                        <a href="{{ $subcategoryUrl }}">{{ $subcategory->name }}<span class="number">({{ $count }})</span></a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                    @endforeach

                </ul>
            </div>
            <div class="sidebar-filter mt-50">
                <div class="top-filter-head">Product Filters</div>
                <div class="common-filter">
                    <div class="head">Price</div>
                    <div class="price-range-area">
                        <div id="price-range"></div>
                        <div class="value-wrapper d-flex">
                            <div class="price">Price:</div>
                            <span>₹</span>
                            <div id="lower-value">0</div>
                            <div class="to"> to </div>
                            <span>₹</span>
                            <div id="upper-value">500000</div>
                        </div>
                        <div class="filter-buttons">
                            <button class="primary-btn apply-filter-btn" type="button" id="apply-filter" data-base-url="{{ url()->current() }}">Apply</button>
                            <button class="primary-btn clear-filter-btn" type="button" onclick="window.location.href = '{{ url()->current() }}'">Clear</button>
                        </div>
                        
                    </div>
                </div>
            </div>
            
        </div>
        <div class="col-xl-9 col-lg-8 col-md-7">
            <!-- Start Filter Bar -->
            <div class="filter-bar d-flex flex-wrap align-items-center">
                <div class="sorting">
                    <select onchange="sortProducts(this.value)">
                        <option value="latest" {{ request()->input('sort') == 'latest' ? 'selected' : '' }}>Latest Products</option>
                        <option value="oldest" {{ request()->input('sort') == 'oldest' ? 'selected' : '' }}>Oldest Products</option>
                        <option value="name_asc" {{ request()->input('sort') == 'name_asc' ? 'selected' : '' }}>Sort By: A-Z</option>
                        <option value="name_desc" {{ request()->input('sort') == 'name_desc' ? 'selected' : '' }}>Sort By: Z-A</option>
                        <option value="price_asc" {{ request()->input('sort') == 'price_asc' ? 'selected' : '' }}>Price: Low - High</option>
                        <option value="price_desc" {{ request()->input('sort') == 'price_desc' ? 'selected' : '' }}>Price: High - Low</option>
                    </select>
                </div>
                <div class="sorting">
                    <select onchange="window.location.href = `{{ url()->current() }}?perPage=${this.value}`">
                        <option value="6" {{ $perPage == 6 ? 'selected' : '' }}>Show 6</option>
                        <option value="12" {{ $perPage == 12 ? 'selected' : '' }}>Show 12</option>
                        <option value="18" {{ $perPage == 18 ? 'selected' : '' }}>Show 18</option>
                    </select>
                </div>
                
                <div class="pagination ml-auto">
                    {{-- Previous Page Link --}}
                    @if ($products->onFirstPage())
                    <a class="prev-arrow"><i class="fa fa-long-arrow-left" aria-hidden="true"></i></a>
                    @else
                        <a href="{{ $products->previousPageUrl() }}" class="prev-arrow"><i class="fa fa-long-arrow-left" aria-hidden="true"></i></a>
                    @endif
                
                    {{-- Pagination Elements --}}
                    @foreach ($products->getUrlRange(1, $products->lastPage()) as $pageNum => $url)
                        @if ($pageNum == $products->currentPage())
                            <a href="#" class="active">{{ $pageNum }}</a>
                        @else
                            <a href="{{ $url }}">{{ $pageNum }}</a>
                        @endif
                    @endforeach
                
                    {{-- Next Page Link --}}
                    @if ($products->hasMorePages())
                        <a href="{{ $products->nextPageUrl() }}" class="next-arrow"><i class="fa fa-long-arrow-right" aria-hidden="true"></i></a>
                    @else
                    <a class="next-arrow"><i class="fa fa-long-arrow-right" aria-hidden="true"></i></a>
                    @endif
                </div>                
            </div>
            <!-- End Filter Bar -->
            <!-- Products Section -->
            @if ($products->isEmpty())
                <div class="alert alert-info mt-4" role="alert">
                    No products found.
                </div>
                <!-- Related products code here -->
            @else
            <!-- Start Best Seller -->
            <section class="lattest-product-area pb-40 category-list">
                <div class="row">
                    @foreach($products as $product)
                    <div class="col-lg-4 col-md-8">
                        <div class="single-product">
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
            </section>
            @endif
        </div>
    </div>
</div>
<script>
    window.addEventListener('DOMContentLoaded', (event) => {
        const productImages = document.querySelectorAll('.img-fluid');
        productImages.forEach(img => {
            img.onload = function() {
                if (img.height > 400) {
                    img.style.height = '400px';
                } else {
                    img.style.height = 'auto'; // Reset to auto if original height is less than 400px
                }
            };
        });
    });
</script>
<script>
    function toggleWishlist(productId) {
        var form = document.getElementById('toggleWishlistForm' + productId);
        form.submit();
    }
</script>
@endsection