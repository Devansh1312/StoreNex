<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Wishlist;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function guestuser()
    {
        if (Auth::check()) {
            return redirect()->route("welcome");
        } else {
            return redirect()->route('customerloginpage')->with('error', 'Please log in first to add products to your wishlist.');
        }
    }

    public function add(Request $request)
    {
        $userId = Auth::id(); // Get the authenticated user's id
        $productId = $request->input('product_id'); // Get product id from form input

        // Check if the product is already in the wishlist
        $wishlistItem = Wishlist::where('user_id', $userId)->where('product_id', $productId)->first();

        if ($wishlistItem) {
            // If the item exists, remove it
            $wishlistItem->delete();
            return redirect()->back()->with('info', 'Product removed from your wishlist!');
        } else {
            // If the item does not exist, add it
            $newWishlistItem = new Wishlist();
            $newWishlistItem->user_id = $userId;
            $newWishlistItem->product_id = $productId;
            $newWishlistItem->save();
            return redirect()->back()->with('success', 'Product added to your wishlist!');
        }
    }

    public function remove(Request $request)
    {
        $userId = Auth::id(); // Get the authenticated user's id
        $productId = $request->input('product_id'); // Get product id from form input

        // Remove product from wishlist
        $item = Wishlist::where('user_id', $userId)->where('product_id', $productId)->first();
        if ($item) {
            $item->delete();
            return redirect()->back()->with('info', 'Product removed from your wishlist!');
        }

        return redirect()->back()->with('error', 'Failed to remove the product from your wishlist.');
    }



    // Retrieve wishlist items for the authenticated user
    public function getWishlistItems()
    {
        $userId = auth()->id(); // Get the authenticated user's ID

        // Retrieve wishlist items for the authenticated user
        $wishlistItems = Wishlist::where('user_id', $userId)->with('product')->get();

        // Return wishlist items to the view
        return view('frontend.product.wishlist', compact('wishlistItems'));
    }

}
