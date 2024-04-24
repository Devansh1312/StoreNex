<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;

use Illuminate\Support\Facades\Hash;

class StaffController extends Controller
{
    private function checkUserRole()
    {
        $user = Auth::user();
        if (!$user || $user->role != 1) {
            abort(
                403,
                "Unauthorized access. You do not have the necessary role to access this!"
            );
        }
    }

    //show index page of staff
    public function Staff()
    {
        $this->checkUserRole();
        $user = Auth::user();
        return view("admin.staff.index", ["staff" => $user]);
    }

    //value in datatables
    function StaffList()
    {
        $this->checkUserRole();
        return User::where("role", "=", 2)->get();
    }

    // staff add page
    public function AddStaffPage()
    {
        $this->checkUserRole();

        return view("admin.staff.addstaff");
    }

    //add new staff
    public function AddStaff(Request $request)
    {
        $this->checkUserRole();

        $request->validate([
            "name" => "required|string",
            "email" => "required|email|unique:users,email",
            "phone" => 'required|string|regex:/^[0-9]{10}$/|unique:users,phone',
            "password" => "required|min:8",
        ]);

        $data["name"] = $request->name;
        $data["email"] = $request->email;
        $data["phone"] = $request->phone;
        $data["password"] = Hash::make($request->password);
        $data["role"] = 2;

        $user = User::create($data);
        if (!$user) {
            return redirect()
                ->route("Staff")
                ->with("error", "Something went wrong");
        }

        return redirect()
            ->route("Staff")
            ->with("success", "Staff added successfully");
    }

    //delete staff detail
    public function DeleteStaff(Request $request)
    {
        $this->checkUserRole();

        $id = $request->input("id");
        $staff = User::find($id);

        if ($staff) {
            $staff->delete();
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

    //view staff detail
    public function ViewStaff($id)
    {
        $this->checkUserRole();
        $id = base64_decode($id);
        $staff = User::find($id);

        if ($staff) {
            return view("admin.staff.viewstaff", compact("staff"));
        } else {
            return response()->json([
                "status" => "error",
                "message" => "Staff not found",
            ]);
        }
    }

    // edit staff details
    public function EditStaff($id)
    {
        $id = base64_decode($id);
        $this->checkUserRole();

        $staff = User::find($id);

        if ($staff) {
            return view("admin.staff.editstaff", compact("staff"));
        } else {
            return response()->json([
                "status" => "error",
                "message" => "Staff not found",
            ]);
        }
    }

    //update Staff details
    public function UpdateStaff(Request $request, $id)
    {
        $this->checkUserRole();
        $id = base64_decode($id);
        $staff = User::find($id);

        if (!$staff) {
            return redirect()
                ->route("Staff")
                ->with("error", "Staff not found");
        }

        $request->validate([
            "edit_name" => "required|string",
            "edit_email" => "required|email|unique:users,email," . $staff->id,
            "edit_phone" =>
            'required|string|regex:/^[0-9]{10}$/|unique:users,phone,' .
                $staff->id,
            "edit_password" => "nullable|min:8", // Add validation for the new password
        ]);

        $staff->name = $request->input("edit_name");
        $staff->email = $request->input("edit_email");
        $staff->phone = $request->input("edit_phone");
        if (
            $request->has("edit_password") &&
            !empty($request->input("edit_password"))
        ) {
            $staff->password = Hash::make($request->input("edit_password"));
        }
        $staff->save();
        return redirect()
            ->route("Staff")
            ->with("success", "Staff updated successfully");
    }
}
