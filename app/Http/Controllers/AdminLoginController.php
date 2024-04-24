<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use App\Models\Cms_page;
use App\Models\Inquirie;
use App\Models\Subcategory;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\SystemSetting;
use App\Models\ProductCategory;
use App\Models\TransactionDetail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AdminLoginController extends Controller
{
    // Check User Role
    private function checkUserRole()
    {
        $user = Auth::user();
        if (!$user || !in_array($user->role, [1, 2])) {
            abort(
                403,
                "Unauthorized access. You do not have the necessary role to access this!"
            );
        }
    }

    //Show Login Page
    public function loginpage()
    {
        $user = Auth::user();
        if ($user) {
            return redirect()->route("admin.dashboard");
        }

        return view("admin.login");
    }

    //Show Dashboard Page
    public function dashboard()
    {
        $user = Auth::user();
        $this->checkUserRole();
        if (!$user) {
            return redirect()
                ->route("admin.login")
                ->with("error", " You are not logged in.");
        }

        // Fetch total numbers
        $totalProductCategories = ProductCategory::count();
        $totalProductSubCategories = Subcategory::count();
        $totalProduct = Product::count();
        $totalUsers = 0; // Initialize $totalUsers
        $totalCustomer = 0; // Initialize $totalCustomer

        $allowedRoles = [1, 2];
        $totalUsers = User::whereIn("role", $allowedRoles)->count();

        $allowedRoles = [3];
        $totalCustomer = User::whereIn("role", $allowedRoles)->count();
        $totalCMS = Cms_page::count();
        $totalInquiries = Inquirie::count();
        $SystemLogo = SystemSetting::all();
        $TotalOrder = Transaction::count();
        $CurrentIncome = Transaction::where('order_status', 'Accepted')->sum('total');
        $CurrentPendingIncome = Transaction::where('order_status', 'pending')->sum('total');



        return view("admin.dashboard", [
            "staff" => $user,
            "totalProductCategories" => $totalProductCategories,
            "totalProductSubCategories" => $totalProductSubCategories,
            "totalProduct" => $totalProduct,
            "totalUsers" => $totalUsers,
            "totalCustomer" => $totalCustomer,
            "totalCMS" => $totalCMS,
            "totalInquiries" => $totalInquiries,
            "SystemLogo" => $SystemLogo,
            "TotalOrder" => $TotalOrder,
            "CurrentIncome" => $CurrentIncome,
            "CurrentPendingIncome" => $CurrentPendingIncome,
        ]);
    }


    // Admin Login Logic
    public function login(Request $request)
    {
        $request->validate([
            "email" => "required|email",
            "password" => "required",
        ]);

        $user = User::where("email", $request->email)->first();

        if ($user) {
            // User found with the provided email
            if (Hash::check($request->password, $user->password)) {
                // Password is correct

                // Check if the user's role is 1 or 2
                if (in_array($user->role, [1, 2])) {
                    Auth::login($user);
                    $request->session()->regenerate();
                    return redirect()->route("admin.dashboard");
                } else {
                    // User has a role other than 1 or 2
                    return redirect(route("admin.login"))->with(
                        "error",
                        "You do not have the necessary role to log in"
                    );
                }
            } else {
                // Password is incorrect
                return redirect(route("admin.login"))->with(
                    "error",
                    "Invalid password"
                );
            }
        }

        // No user found with the provided email
        return redirect(route("admin.login"))->with(
            "error",
            "Invalid credentials"
        );
    }

    // Logout Function
    public function logout()
    {
        Session::flush();
        Auth::logout();
        return redirect(route("admin.login"));
    }
}
