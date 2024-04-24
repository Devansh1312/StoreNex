<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
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
    //show index page of Customer
    public function Customer()
    {
        $this->checkUserRole();
        $user = Auth::user();
        if (!$user) {
            return redirect()
                ->route("admin.login")
                ->with("error", "  You are not logged in.  ");
        }
        return view("admin.customer.index", ["customer" => $user]);
    }

    //value in datatables
    function CustomerList()
    {
        $this->checkUserRole();
        return User::where("role", "=", 3)->get();
    }

    //view customer detail
    public function ViewCustomer($id)
    {
        $id = base64_decode($id);
        $this->checkUserRole();
        $Customer = User::find($id);

        if ($Customer) {
            return view("admin.customer.viewcustomer", compact("Customer"));
        } else {
            return response()->json([
                "status" => "error",
                "message" => "Customer not found",
            ]);
        }
    }

    //delete Customer detail
    public function DeleteCustomer(Request $request)
    {
        $this->checkUserRole();

        $id = $request->input("id");
        $Customer = User::find($id);

        if ($Customer) {
            $Customer->delete();
            return response()->json([
                "status" => "success",
                "message" => "Staff deleted successfully",
            ]);
        } else {
            return response()->json([
                "status" => "error",
                "message" => "Staff not found",
            ]);
        }
    }
}
