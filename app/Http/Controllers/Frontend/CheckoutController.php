<?php

namespace App\Http\Controllers\Frontend;
use App\Models\Cart;
use Razorpay\Api\Api;
use App\Models\Transaction;
use App\Mail\OrderplaceMail;
use Illuminate\Http\Request;
use App\Models\TransactionDetail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Razorpay\Api\Errors\SignatureVerificationError;

class CheckoutController extends Controller
{

    public function logPaymentResponse(Request $request)
    {
        try {
            $response = $request->all();
            Log::info('Payment response received:', $response);
            return response()->json(['message' => 'Payment response logged successfully'], 200);
        } catch (\Exception $e) {
            Log::error('Error logging payment response: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to log payment response'], 500);
        }
    }
    // Show Checkout Page
    public function checkout()
    {
        $user = Auth::user();
        if ($user) {
            $cartItems = Cart::where("user_id", $user->id)->get();
            if ($cartItems->isEmpty()) {
                return redirect()
                    ->back()
                    ->with(
                        "info",
                        "Your cart is empty. Please add products to your cart before checking out."
                    );
            }
            return view("frontend.order.checkout", compact("cartItems"));
        } else {
            return redirect()
                ->route("customerloginpage")
                ->with("error", "Please login to view your cart.");
        }
    }

    public function processCheckout(Request $request)
    {
        $user = Auth::user();
        // Check if the payment method is 'online'
        if ($request->payment_method === 'online')
        {
            try {
                $api = new Api(env('RAZORPAY_KEY_ID'), env('RAZORPAY_KEY_SECRET'));
                
                // Create a new transaction record
                $transaction = Transaction::create([
                    "user_id" => $user->id,
                    "name" => $user->name,
                    "email" => $user->email,
                    "phone" => $request->phone,
                    "addressline1" => $request->addressline1,
                    "addressline2" => $request->addressline2,
                    "city" => $request->city,
                    "district" => $request->district,
                    "zip_code" => $request->zip_code,
                    "order_status" => "pending",
                    "total" => $request->total,
                ]);

                $order = $api->order->create([
                    'receipt' => 'order_' . $transaction->id,
                    'amount' => $request->total * 100, // Amount in paisa
                    'currency' => 'INR',
                    'payment_capture' => 1
                ]);

                $transaction->razorpay_order_id = $order->id;
                $transaction->save();
                // $request->all();
                $razorpay_payment_id = $request->razorpay_payment_id;
                // dd($request);
                return redirect()->route('frontend.order.verifyPayment', [
                    'razorpay_payment_id' => $razorpay_payment_id,
                    'OrderId' => $transaction->razorpay_order_id,
                    'transactionId' => $transaction->id
                ]);
            } catch (\Exception $e) {
                Log::error("Order processing failed", ["error" => $e->getMessage()]);
                return back()->with("error", "Failed to place the order. Please try again later.");
            }
        } elseif ($request->payment_method === 'cod') {
            // Call COD function
            return $this->COD($request);
        } else {
            return back()->with("error", "Invalid payment method selected.");
        }
    }

    public function verifyPayment(Request $request)
    {
        // Validate the request
        $request->validate([
            'razorpay_payment_id' => 'required',
        ]);

        $id = $request->razorpay_payment_id;

        try {
            // Initialize the Razorpay API with your credentials
            $api = new Api(env('RAZORPAY_KEY_ID'), env('RAZORPAY_KEY_SECRET'));

            // Fetch the payment details from Razorpay
            $payment = $api->payment->fetch($id);
            
            // Check if the payment status is 'captured'
            if ($payment->status === 'authorized') {
                // Find the transaction using transactionId and update its status to 'Paid'
                $transaction = Transaction::findOrFail($request->transactionId);
                $transaction->status = 'Paid'; // Update the status to 'Paid' or 'completed', whichever you prefer
                $transaction->razorpay_payment_id = $id;

                // Begin a transaction
                DB::beginTransaction();

                // Save the transaction
                $transaction->save();

                // Fetch cart items for the user
                $user = auth()->user();
                $cartItems = Cart::where("user_id", $user->id)->get();

                // Create transaction details for each cart item
                foreach ($cartItems as $item) {
                    TransactionDetail::create([
                        "transaction_id" => $transaction->id,
                        "product_id" => $item->product_id,
                        "quantity" => $item->quantity,
                        "price" => $item->total_amount,
                    ]);
                }

                // Commit the transaction
                DB::commit();

                // Send an order confirmation email to the user
                Mail::to($user->email)->send(new OrderplaceMail($transaction, $user, $cartItems));

                // Clear the user's cart
                Cart::where("user_id", $user->id)->delete();

                // Redirect the user to the order history page with a success message
                return redirect()->route('OrderHistory')->with("success", "Your Order Placed Successfully");
            }

            // If the payment status is not 'captured', return back with an error message
            return back()->with("error", "Payment failed. Please try again.");

        } 
        // catch (SignatureVerificationError $e) {
        //     // Handle signature verification errors (e.g., invalid API credentials)
        //     Log::error("Signature verification failed", ["error" => $e->getMessage()]);
        //     return back()->with('error', 'Signature verification failed. Please check your API credentials.');

        // } 
        catch (\Exception $e) {
            // Log any other exceptions that occur during payment verification
            Log::error("Payment verification failed", ["error" => $e->getMessage()]);
            // Redirect the user back with an error message
            return back()->with('error', 'Payment verification failed. Please try again later.');
        }
    }

    // Process Checkout and enter data in database and send mail to user with order Details
    public function COD(Request $request)
    {
        $request->validate([
            "phone" => 'required|string|regex:/^[0-9]{10}$/',
            "addressline1" => "required|string",
            "addressline2" => "nullable|string",
            "city" => "required|string",
            "district" => "required|string",
            "zip_code" => "required|string|regex:/^[0-9]{6,8}$/",
            "total" => "required|numeric", // Ensure 'total' is included and valid
        ]);

        $user = Auth::user();

        $cartItems = Cart::where("user_id", $user->id)->get();
        if ($cartItems->isEmpty()) {
            return redirect()
                ->route("welcome")
                ->with(
                    "info",
                    "Your cart is empty. Please add products to your cart before proceeding to checkout."
                );
        }

        DB::beginTransaction();

        try {
            // Create a new transaction record
            $transaction = Transaction::create([
                "razorpay_order_id"=> "COD",
                "razorpay_payment_id"=> "COD",
                "status" => "COD",
                "user_id" => $user->id,
                "name" => $user->name,
                "email" => $user->email,
                "phone" => $request->phone,
                "addressline1" => $request->addressline1,
                "addressline2" => $request->addressline2,
                "city" => $request->city,
                "district" => $request->district,
                "zip_code" => $request->zip_code,
                "order_status" => "pending",
                "total" => $request->total,
            ]);

            $cartItems = Cart::where("user_id", $user->id)->get();

            foreach ($cartItems as $item) {
                TransactionDetail::create([
                    "transaction_id" => $transaction->id,
                    "product_id" => $item->product_id,
                    "quantity" => $item->quantity,
                    "price" => $item->total_amount,
                ]);
            }

            DB::commit();

            // Optional: Send an order confirmation email to the user
            Mail::to($user->email)->send(new OrderplaceMail($transaction, $user, $cartItems));

            // Flash transaction and cartItems data to session
            session()->flash("transaction", $transaction->load("details"));
            session()->flash("cartItems", $cartItems);

            Cart::where("user_id", $user->id)->delete();
            return redirect()->route('OrderHistory')->with(
                "success",
                "Your Order Placed Successfully"
            );
            // return redirect()->route("thankyou");
        } catch (\Exception $e) {
            // Rollback the transaction in case of errors
            DB::rollBack();
            Log::error("Order processing failed", [
                "error" => $e->getMessage(),
            ]);

            // Return back to the checkout page with an error message
            return back()->with(
                "error",
                "Failed to place the order. Please try again later."
            );
        }
    }
}
