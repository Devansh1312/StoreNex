<?php

namespace App\Http\Controllers\Frontend;
use App\Models\cart;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\TransactionDetail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // Show Cart Page
    public function showCart()
    {
        $user = Auth::user();
        if ($user) {
            $cartItems = Cart::where("user_id", $user->id)->get();
            return view("frontend.Order.cart", compact("cartItems"));
        } else {
            return redirect()
                ->route("customerloginpage")
                ->with("error", "Please login to view your cart.");
        }
    }

    //Add PRoduct In Cart
    public function addToCart(Request $request, $productId)
    {
        $productId = base64_decode($productId);
        $product = Product::findOrFail($productId);
        if (Auth::check()) {
            $userId = auth()->id();
            $existingCartItem = Cart::where("user_id", $userId)
                ->where("product_id", $productId)
                ->first();

            if ($existingCartItem) {
                $newQuantity =
                    $existingCartItem->quantity + $request->input("qty", 1);
                $totalAmount = $product->price * $newQuantity;

                $existingCartItem->update([
                    "quantity" => $newQuantity,
                    "total_amount" => $totalAmount,
                ]);
            } else {
                Cart::create([
                    "user_id" => $userId,
                    "product_id" => $productId,
                    "quantity" => $request->input("qty", 1),
                    "total_amount" =>
                        $product->price * $request->input("qty", 1),
                ]);
            }

            return redirect()
                ->route("cart")
                ->with("success", "Product added to cart successfully");
        } else {
            return redirect()
                ->route("customerloginpage")
                ->with("error", "Please login to add items to your cart.");
        }
    }


    //Update Cart Details
    public function updatecart(Request $request)
    {
        $cartItemId = $request->input("cart_item_id");
        $quantity = $request->input("quantity");

        $cartItem = Cart::find($cartItemId);
        if ($cartItem) {
            $cartItem->quantity = $quantity;
            $cartItem->total_amount = $cartItem->product->price * $quantity;
            $cartItem->save();
        }

        return redirect()
            ->back()
            ->with("success", "Cart updated successfully");
    }


    //Remove Value From Cart
    public function removeFromCart(Request $request)
    {
        $cartItemId = $request->input("cart_item_id");
        $cartItem = Cart::find($cartItemId);

        if ($cartItem) {
            $cartItem->delete();
            session()->flash(
                "success",
                "Product removed from cart successfully"
            );
            return response()->json([
                "status" => "success",
                "message" => "Product removed from cart successfully",
            ]);
        } else {
            return redirect()
                ->back()
                ->with(["error" => "Item not found."], 404);
        }
    }
}
