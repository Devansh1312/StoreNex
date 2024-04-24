<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Cms_page;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PageController extends Controller
{
    // Auth User or not
    private function checkUserRole()
    {
        $user = Auth::user();
        if (!$user) {
            abort(
                403,
                "Unauthorized access. You do not have the necessary role to access this!"
            );
        }
    }

    // Show About Us page
    public function AboutUs()
    {
        $AboutUs = Cms_page::first();
        return view("frontend.CMS.aboutuspage", [
            "AboutUs" => $AboutUs,
        ]);
    }

    // Show FAQ page
    public function FAQ()
    {
        $FAQ = Cms_page::skip(1)
            ->take(1)
            ->first(); // Skip the first record and take the next one
        return view("frontend.CMS.FAQ", [
            "FAQ" => $FAQ,
        ]);
    }

    // Show ContactUs page
    public function ContactUs()
    {
        $ContactUs = Cms_page::skip(2)
            ->take(1)
            ->first(); // Skip the first record and take the next one

        return view("frontend.CMS.ContactUs", [
            "ContactUs" => $ContactUs,
        ]);
    }

    // Show FAQ page
    public function TermsAndCondition()
    {
        $TermsAndCondition = Cms_page::skip(2)
            ->take(1)
            ->first(); // Skip the first record and take the next one

        return view("frontend.CMS.TermsAndCondition", [
            "TermsAndCondition" => $TermsAndCondition,
        ]);
    }

    // Show Profile Page
    public function Profile()
    {
        $this->checkUserRole();

        return view("frontend.Auth.profile");
    }

    //Update User Information
    public function UpdateProfile(Request $request)
    {
        $user = Auth::user();

        $this->checkUserRole();

       $request->validate([
            "name" => "required|string",
            "email" => "required|email|unique:users,email," . $user->id,
            "phone" => 'required|string|regex:/^[0-9]{10}$/|unique:users,phone,' . $user->id,
            "old_password" => "nullable|min:8",
            "new_password" => "nullable|min:8",
        ]);


        // Update user information
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->save();

        // Update password if a new password is provided
        if ($request->filled("old_password") && !$request->filled("new_password")) {
            // If old password is provided but new password is not provided, return an error
            return redirect()
                ->back()
                ->with("error", "New password is required when changing your password.");
        }

        // Update password if a new password is provided
        if ($request->filled("new_password") && !$request->filled("old_password")) {
            // If new password is provided but old password is not provided, return an error
            return redirect()
                ->back()
                ->with("error", "Old password is required when setting a new password.");
        }

        // Update password if a new password is provided
        if ($request->filled("new_password")) {
            // Check if the old password matches the one in the database
            if (!Hash::check($request->old_password, $user->password)) {
                return redirect()
                    ->back()
                    ->with("error", "Old password does not match.");
            }

            try {
                $user->password = Hash::make($request->new_password);
                $user->save();
                Auth::logout();
                return redirect(route("welcome"))->with(
                    "success",
                    "Password Change successfully. Please login again with your new password."
                );
            } catch (\Exception $e) {
                return redirect()
                    ->back()
                    ->with(
                        "error",
                        "Error in changing password: " . $e->getMessage()
                    );
            }
        } else {
            return redirect()
                ->back()
                ->with("success", "Profile updated successfully.");
        }
    }

    public function OrderHistory()
    {
        // Retrieve the currently authenticated user
        $user = Auth::user();
        
        // Check the role of the user, assuming there's a method called checkUserRole()
        $this->checkUserRole();
    
        // Query transactions where the user_id matches the ID of the authenticated user
        // Also, eager load the details of each transaction and the associated product details
        $transactions = Transaction::where("user_id", $user->id)
            ->with("details", "details.product")
            ->where(function($query) {
                $query->where("status", "Paid")
                      ->orWhere("status", "COD");
            })            ->orderBy("created_at", "desc")
            ->get();
        // dd($transactions);
        // Return a view with the fetched transactions
        return view("frontend.Order.OrderHistory", compact("transactions"));
    }
    

    // Show Single Order Histroy With All product details
    public function SingleOrder($id)
    {
        $user = Auth::user();
        $this->checkUserRole();
        $id = base64_decode($id);
        $order = Transaction::where("id", $id)
            ->where("user_id", $user->id)
            ->with("details.product")
            ->first();

        // Check if the order exists
        if (!$order) {
            return redirect()
                ->route("OrderHistory")
                ->with("error", "Order not found.");
        }

        return view("frontend.Order.SingleOrder", compact("order"));
    }
}
