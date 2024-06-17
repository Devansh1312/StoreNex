
@extends('frontend.layouts.app')

@section('content')
<section class="banner-area organic-breadcrumb">
    <div class="container">
        <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
            <div class="col-first">
                <h1>CheckOut</h1>
            </div>
        </div>
    </div>
</section>

<section class="checkout_area section_gap">
    <div class="container">
        <div class="billing_details">
            <form id="checkout-form" action="{{ route('checkout.process') }}" method="post">
                @csrf
                <div class="row">
                    <div class="col-lg-8">
                        <h3>Billing Details</h3>
                        <div class="form-group col-md-6">
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', auth()->user()->name) }}" readonly>
                        </div>
                        <div class="form-group col-md-6">
                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email', auth()->user()->email) }}" readonly>
                        </div>
                        <div class="form-group col-md-6">
                            <input type="text" class="form-control" id="phone" name="phone" placeholder="Phone number *" value="{{ old('phone') }}">
                            @error('phone')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group col-md-12">
                            <input type="text" class="form-control" id="addressline1" name="addressline1" placeholder="Address line 01 *" value="{{ old('addressline1') }}">
                            @error('addressline1')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group col-md-12">
                            <input type="text" class="form-control" id="addressline2" name="addressline2" placeholder="Address line 02" value="{{ old('addressline2') }}">
                            @error('addressline2')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group col-md-12">
                            <input type="text" class="form-control" id="city" name="city" placeholder="Town/City *" value="{{ old('city') }}">
                            @error('city')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group col-md-12">
                            <input type="text" class="form-control" id="district" name="district" placeholder="State *" value="{{ old('district') }}">
                            @error('district')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group col-md-12">
                            <input type="text" class="form-control" id="zip_code" name="zip_code" placeholder="Postcode/ZIP *" value="{{ old('zip_code') }}">
                            @error('zip_code')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id">
                        <input type="hidden" name="total" value="{{ $cartItems->sum('total_amount') }}">
                        <input type="hidden" name="payment_method" id="payment_method">
                    </div>
                    <div class="col-lg-4">
                        <div class="order_box">
                            <h2>Your Order</h2>
                            <div class="table-responsive">
                                <!-- Order Summary Table -->
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">Product</th>
                                            <th scope="col">Quantity</th>
                                            <th scope="col">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($cartItems as $cartItem)
                                        <tr>
                                            <td>{{ $cartItem->product->name }}</td>
                                            <td>{{ $cartItem->quantity }}</td>
                                            <td>₹{{ number_format($cartItem->total_amount, 2) }}</td>
                                        </tr>
                                        @endforeach
                                        <tr>
                                            <td colspan="2"><strong>Subtotal</strong></td>
                                            <td>₹{{ number_format($cartItems->sum('total_amount'), 2) }}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2"><strong>Total</strong></td>
                                            <td><strong>₹{{ number_format($cartItems->sum('total_amount'), 2) }}</strong></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="row" style="font-size: 10px;">
                                <div class="col-md-6" style="padding: 0;">
                                    <button type="submit" class="primary-btn" id="pay-button" name="payment_method" value="online">Pay Online</button>
                                </div>
                                <div class="col-md-6" style="padding: 0;">
                                    <button type="submit" class="primary-btn" name="payment_method" value="cod">Cash On Delivery</button>
                                </div>
                            </div>                            
                        </div>
                    </div>                                        
                </div>
            </form>
        </div>
    </div>
</section>

<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
    document.getElementById('pay-button').onclick = function (e) {
        // Function to validate the form fields
        function validateForm() {
            var phone = document.getElementById('phone').value;
            var addressline1 = document.getElementById('addressline1').value;
            var city = document.getElementById('city').value;
            var district = document.getElementById('district').value;
            var zip_code = document.getElementById('zip_code').value;

            // Regular expressions for validation
            var phoneRegex = /^\d{10}$/;
            var zipCodeRegex = /^\d{6,10}$/;

            // Validation checks
            if (!phoneRegex.test(phone)) {
                appendError('phone', 'Please enter a valid 10-digit phone number.');
                return false;
            }
            if (addressline1.trim() === '') {
                appendError('addressline1', 'Address line 1 is required.');
                return false;
            }
            if (!/^[a-zA-Z\s]+$/.test(city)) {
                appendError('city', 'City must contain only letters.');
                return false;
            }
            if (!/^[a-zA-Z\s]+$/.test(district)) {
                appendError('district', 'District must contain only letters.');
                return false;
            }
            if (!zipCodeRegex.test(zip_code)) {
                appendError('zip_code', 'Zip code must be a number with 6 to 10 digits.');
                return false;
            }
            return true; // Form is valid
        }

        // Function to append error messages dynamically
        function appendError(fieldName, message) {
            var fieldElement = document.getElementById(fieldName);
            var errorDiv = document.createElement('div');
            errorDiv.className = 'text-danger';
            errorDiv.textContent = message;
            // Remove previous error message, if any
            var existingError = fieldElement.parentElement.querySelector('.text-danger');
            if (existingError) {
                existingError.remove();
            }
            // Append the new error message
            fieldElement.parentElement.appendChild(errorDiv);
        }

        // Remove all existing error messages before validation
        document.querySelectorAll('.text-danger').forEach(function (element) {
            element.remove();
        });

        // Perform form validation before proceeding to payment
        if (validateForm()) {
            var totalAmount = {{ $cartItems->sum('total_amount') * 100 }};
            var options = {
                "key": "rzp_test_0ZVF5cPATwT9nC",
                "amount": totalAmount, // Amount is in currency subunits
                "currency": "INR",
                "name": "StoreNex",
                "description": "Test Transaction",
                "image": "{{ asset('storage/SystemSetting/systemlogo.png') }}",
                "handler": function (response) {
                    document.getElementById('razorpay_payment_id').value = response.razorpay_payment_id;
                    document.getElementById('checkout-form').submit();
                },
                "prefill": {
                    "name": "{{ auth()->user()->name }}",
                    "email": "{{ auth()->user()->email }}",
                    "contact": "{{ auth()->user()->phone }}"
                },
                "notes": {
                    "address": "note value"
                },
                "theme": {
                    "color": "#F37254"
                }
            };
            var rzp1 = new Razorpay(options);
            rzp1.open();
            e.preventDefault();
        } else {
            e.preventDefault(); // Prevent form submission if validation fails
        }
    }

    // Event listeners for payment method buttons
    document.querySelectorAll('.primary-btn').forEach(function(button) {
        button.addEventListener('click', function() {
            var paymentMethod = this.value; // Get the value of the clicked button
            document.getElementById('payment_method').value = paymentMethod; // Set the value of the hidden input field
        });
    });
</script>
@endsection
