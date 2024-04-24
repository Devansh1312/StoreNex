<?php

namespace App\Http\Controllers;
use App\Models\Inquirie;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\IpUtils;

class InquiriesController extends Controller
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
    //show index page of Inquiries
    public function Inquiries()
    {
        $this->checkUserRole();
        $user = Auth::user();
        return view("admin.inquiries.index", ["Inquiries" => $user]);
    }

    //value in datatables
    function InquiriesList()
    {
        $this->checkUserRole();

        return Inquirie::get();
    }

    // View Inquiries
    public function ViewInquiries($id)
    {
        $id = base64_decode($id);
        $this->checkUserRole();

        $Inquiries = Inquirie::find($id);

        if ($Inquiries) {
            return view("admin.inquiries.viewinquiries", compact("Inquiries"));
        } else {
            return redirect()
                ->route("Inquiries")
                ->with("error", "  Inquirie page not found  ");
        }
    }

    //delete Inquirie detail
    public function DeleteInquiries(Request $request)
    {
        $this->checkUserRole();

        $id = $request->input("id");
        $Inquiries = Inquirie::find($id);

        if ($Inquiries) {
            $Inquiries->delete();
            return response()->json([
                "status" => "success",
                "message" => "Inquiries deleted successfully",
            ]);
        } else {
            return response()->json([
                "status" => "error",
                "message" => "Inquiries not found",
            ]);
        }
    }

    // Add Inquires
    public function AddInquiries(Request $request)
    {
        $request->validate([
            "name" => "required|string",
            "email" => "required|email",
            "phone" => 'required|string|regex:/^[0-9]{10}$/',
            "message" => "required|string",
            "g-recaptcha-response" => "required",
        ]);

        $recaptchaSecret = "6LdEX5ApAAAAAPvV_484xjcQW25uNX0nA1asS_xQ";
        // The rest of the server-side verification remains the same
        $recaptchaResponse = $request->input("g-recaptcha-response");

        $url = "https://www.google.com/recaptcha/api/siteverify";

        $body = [
            "secret" => $recaptchaSecret,
            "response" => $recaptchaResponse,
            "remoteip" => IpUtils::anonymize($request->ip()), //anonymize the ip to be GDPR compliant. Otherwise just pass the default ip address
        ];

        $response = Http::asForm()->post($url, $body);

        if (!$response->json()["success"]) {
            return back()
                ->withErrors(["captcha" => "ReCAPTCHA verification failed"])
                ->withInput();
        }

        $data["name"] = $request->name;
        $data["email"] = $request->email;
        $data["phone"] = $request->phone;
        $data["message"] = $request->message;

        $data = Inquirie::create($data);
        if (!$data) {
            return redirect()
                ->route("ContactUs")
                ->with("error", "Something went wrong");
        }

        return redirect()
            ->route("ContactUs")
            ->with("success", "Inquiry Submited Successfully");
    }
}
