@extends('frontend.layouts.app')

@section('content')

<!-- Start Banner Area -->
<section class="banner-area organic-breadcrumb">
    <div class="container">
        <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
            <div class="col-first">
                <h1>Shopping Cart</h1>
            </div>
        </div>
    </div>
</section>
<!-- End Banner Area -->

<!--================Cart Area =================-->
<section class="cart_area">
    <div class="container">
        <div class="cart_inner">
            @if($cartItems && count($cartItems) > 0)
            <div class="table-responsive">
                <table class="table">
                    <!-- Table header -->
                    <thead>
                        <tr>
                            <th scope="col">Product</th>
                            <th scope="col">Price</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Total</th>
                            <th scope="col">Remove</th>
                        </tr>
                    </thead>
                    <!-- Table body -->
                    <tbody>
                        @php
                            $grandTotal = 0; // Initialize grand total variable
                        @endphp
                        @if($cartItems && count($cartItems) > 0)                               
                        <!-- Cart items loop -->
                        @foreach($cartItems as $cartItem)
                        @php
                            $subTotal = $cartItem->product->price * $cartItem->quantity; // Calculate subtotal for each product
                            $grandTotal += $subTotal; // Add subtotal to grand total
                        @endphp
                        <!-- Cart item row -->
                        <tr>
                            <!-- Product details -->
                            <td>
                                <div class="media">
                                    <a href="{{ route('product.show', ['id' => base64_encode($cartItem->product_id)]) }}">
                                    <div class="d-flex">
                                        @php
                                            $images = explode(",", $cartItem->product->image);
                                            $lastImage = reset($images);
                                        @endphp
                                        <img style="height:100px; width:100px; border:1px solid #ccc; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);" src="{{ asset('storage/ProductIMG/' .$lastImage) }}" alt="{{ $cartItem->product->name }}">
                                    </div>
                                    <div class="media-body">
                                        <p>{{ $cartItem->product->name }}</p>
                                        </a>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <h5>₹{{ number_format($cartItem->product->price, 2) }}</h5>
                            </td>
                            <td>
                                <div class="product_count">
                                    <!-- Increment Quantity button -->
                                    <button onclick="incrementQuantity({{ $cartItem->id }})"></button>
                                    <!-- Quantity input field -->
                                    <input type="number" id="quantity_{{ $cartItem->id }}" value="{{ $cartItem->quantity }}" min="1">
                                    <!-- Decrement Quantity button (if needed) -->
                                    <!-- <button onclick="decrementQuantity({{ $cartItem->id }})">-</button> -->
                                </div>
                            </td>     
                            <!-- Product total -->
                            <td>
                                <h5 id="total_{{ $cartItem->id }}">₹{{ number_format($cartItem->total_amount, 2) }}</h5>
                            </td>
                            <!-- Remove product -->
                            <td>
                                <span class="remove_item_btn" data-id="{{ $cartItem->id }}" style="cursor: pointer;padding: 5px; border-radius: 50%;">
                                    <i class="fas fa-trash" style="color: rgb(0, 0, 0);"></i>
                                </span>
                            </td>
                        </tr>
                        @endforeach
                        @endif
                        <!-- End of cart items loop -->

                        <!-- Display grand total -->
                        <tr>
                            <td></td>
                            <td colspan="2">
                                <h5>Grand Total:</h5>
                            </td>
                            <td>
                                <h5 id="grand_total">₹{{ number_format($grandTotal, 2) }}</h5>
                            </td>
                            <td></td>
                        </tr>
                        <!-- End of grand total -->

                        <!-- Buttons -->
                        <tr>
                            <td>
                                <a style="color: aliceblue" class="primary-btn" onclick="applyChanges()">Update Cart</a>
                            </td>
                            <td></td>
                            <td></td>
                            <td colspan="2">
                                <a href="{{route('Checkout')}}" style="color: aliceblue" class="primary-btn">Check Out</a>
                            </td>
                        </tr>
                        <!-- End of buttons -->
                    </tbody>
                    <!-- End of table body -->
                </table>
            </div>
            <!-- End of table-responsive -->
            @else
            <!-- Cart is empty message -->
            <div class="text-center" style="margin-top: 50px;">
                <h1 style="font-size: 36px;">YOUR CART IS CURRENTLY EMPTY.</h1>
            </div>
            <div class="text-center" style="margin-top: 10px;">
                <a href="{{route('welcome')}}" style="color: aliceblue" class="primary-btn">Return to shop</a>
            </div>
            <!-- End of cart is empty message -->
            @endif
        </div>
        <!-- End of cart_inner -->
    </div>
    <!-- End of container -->
</section>
<!--================End Cart Area =================-->

<script>
function incrementQuantity(cartItemId) {
    var quantityInput = document.getElementById('quantity_' + cartItemId);
    var currentQuantity = parseInt(quantityInput.value);
    quantityInput.value = currentQuantity + 1;
}

$(document).ready(function() {
    $('.remove_item_btn').click(function() {
        var cartItemId = $(this).data('id'); // Ensure your button has a data-id attribute

        Swal.fire({
            title: 'Are you sure?',
            text: 'You will not be able to recover this product!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, keep it',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('cart.remove') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        cart_item_id: cartItemId,
                    },
                    success: function(response) {
                        // Optionally, refresh the page or remove the item from the view
                        location.reload();
                    },
                    error: function(xhr) {
                        // Handle error
                        console.log(xhr.responseText);
                    }
                });
            }
        });
    });
});




function applyChanges() {
    // Initialize grand total variable
    var grandTotal = 0;

    // Loop through each cart item
    @foreach($cartItems as $cartItem)
        var quantityInput = document.getElementById('quantity_{{ $cartItem->id }}');
        var quantity = quantityInput.value.trim(); // Trim whitespace from input
        var cartItemId = {{ $cartItem->id }};
        
        // Check if quantity is not a number or less than or equal to 0, or if it's a decimal value
        if (isNaN(quantity) || quantity <= 0 || quantity % 1 !== 0) {
            quantity = 1;
            quantityInput.value = 1; // Update input field value
        } else {
            // Parse quantity to integer if it's a valid number
            quantity = parseInt(quantity);
        }

        // Calculate subtotal
        var subTotal = quantity * {{ $cartItem->product->price }};

        // Add subtotal to grand total
        grandTotal += subTotal;

        // AJAX request to update cart item
        $.ajax({
            url: "{{ route('cart.update') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                cart_item_id: cartItemId,
                quantity: quantity
            },
            success: function(response) {
                // Update the total amount displayed
                var total = parseFloat(subTotal).toFixed(2);
                document.getElementById('total_{{ $cartItem->id }}').innerText = "₹ " + total;

                // Update grand total
                document.getElementById('grand_total').innerText = "₹ " + parseFloat(grandTotal).toFixed(2);
                
                // Reload the page after successful update
                location.reload();
            },
            error: function(xhr) {
                console.log(xhr.responseText);
            }
        });
    @endforeach
}
</script>
@endsection
