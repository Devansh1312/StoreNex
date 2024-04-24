<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\SystemSetting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
class SystemSettingController extends Controller
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
    // show index page of SystemSetting
    public function SystemSetting()
    {
        $this->checkUserRole();
        $SystemSetting = SystemSetting::first();
        return view("admin.systemsetting.index", compact("SystemSetting"));
    }
    // update SystemSetting details
    public function UpdateSystemSetting(Request $request, $id)
    {
        $id = base64_decode($id);
        $this->checkUserRole();
        $SystemSetting = SystemSetting::find($id);
        if (!$SystemSetting) {
            return redirect()
                ->route("SystemSetting")
                ->with("error", "SystemSetting not found");
        }
        $request->validate([
            "logo" => "nullable|image|mimes:png|max:128000",
            "email" => "required|email",
            "phone" => 'required|string|regex:/^[0-9]{10}$/',
            "address" => "required|string",
            "facebook" => "nullable|string|url",
            "instagram" => "nullable|string|url",
            "linkedin" => "nullable|string|url",
            "twitter" => "nullable|string|url",
        ]);
        // Update SystemSetting fields
        $SystemSetting->email = $request->input("email");
        $SystemSetting->phone = $request->input("phone");
        $SystemSetting->address = $request->input("address");
        $SystemSetting->facebook = $request->input("facebook");
        $SystemSetting->instagram = $request->input("instagram");
        $SystemSetting->linkedin = $request->input("linkedin");
        $SystemSetting->twitter = $request->input("twitter");
        // Handle file upload...
        if ($request->hasFile("logo")) {
            // Delete old logo if exists
            Storage::delete("public/SystemSetting/" . $SystemSetting->logo);
            // Store the new logo
            $fileName =
                "systemlogo" .
                "." .
                $request->file("logo")->getClientOriginalExtension();
            Storage::putFileAs(
                "public/SystemSetting",
                $request->file("logo"),
                $fileName
            );
            $SystemSetting->logo = $fileName;
        }
        $SystemSetting->save();

        return redirect()
            ->route("SystemSetting")
            ->with("success", "SystemSetting updated successfully");
    }
}
