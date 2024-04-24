<?php

namespace App\Http\Controllers\Frontend;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Mail\ForgotPasswordMail;
use App\Mail\RegisterMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use PhpParser\Node\Stmt\Return_;

class AuthController extends Controller
{
    // Customer Login Page
    public function customerloginpage()
    {
        if (Auth::check()) {
            return redirect()->route("welcome");
        }
        return view("frontend.Auth.loginpage");
    }

    // Login Logic
    public function customerlogin(Request $request)
    {
        $request->validate([
            "email" => "required|email",
            "password" => "required",
        ]);

        $user = User::where("email", $request->email)->first();

        if ($user) {
            // Check if the user's email is verified
            if (!$user->hasVerifiedEmail()) {
                // If user's email is not verified and has no remember token, resend verification email
                if (!$user->remember_token) {
                    $user->update(["remember_token" => Str::random(40)]);
                    $verificationUrl = route("verification.verify", [
                        "token" => $user->remember_token,
                    ]);
                    Mail::to($user->email)->send(
                        new RegisterMail($user, $verificationUrl)
                    );
                    return redirect()
                        ->back()
                        ->with(
                            "warning",
                            "Verification email resent. Please verify your email first before logging in."
                        );
                }
                return redirect()
                    ->back()
                    ->with(
                        "error",
                        "Please verify your email first before logging in."
                    );
            }

            // User found with the provided email
            if (Hash::check($request->password, $user->password)) {
                // Password is correct

                // Check if the user's role is 1
                if ($user) {
                    Auth::login($user);
                    $request->session()->regenerate();
                    return redirect()->route("welcome")->with(
                        "success",
                        "Login Successfully..."
                    );;
                }
            } else {
                // Password is incorrect
                return redirect()
                    ->back()
                    ->with("error", "Invalid password");
            }
        }

        // No user found with the provided email
        return redirect()
            ->back()
            ->with("error", "Invalid credentials");
    }

    //Customer Register page
    public function Customerregisterpage()
    {
        if (Auth::check()) {
            return redirect()->route("welcome");
        }

        return view("frontend.Auth.registerpage");
    }

    // Customer Detail Insert In Database and Send Verify Token To User via Email
    public function customeradd(Request $request)
    {
        $request->validate([
            "name" => "required|string",
            "email" => "required|email|unique:users,email",
            "phone" => 'required|string|regex:/^[0-9]{10}$/|unique:users,phone',
            "password" => "required|min:8",
        ]);

        $user = User::create([
            "name" => $request->name,
            "email" => $request->email,
            "phone" => $request->phone,
            "password" => Hash::make($request->password),
            "remember_token" => Str::random(40), // Ensure remember_token is generated
            "role" => 3,
        ]);

        // Generate verification URL with remember_token
        $verificationUrl = route("verification.verify", [
            "token" => $user->remember_token,
        ]);

        // Send email verification notification
        Mail::to($request->email)->send(
            new RegisterMail($user, $verificationUrl)
        );

        // Redirect the user after registration
        return redirect()
            ->route("welcome")
            ->with(
                "success",
                "You have signed up successfully. Please check your email for verification."
            );
    }

    //Email Verification After Customer Register
    public function verify(Request $request, $token)
    {
        // Find the user by the verification token
        $user = User::where("remember_token", $token)->first();

        if (!$user) {
            // If user not found, redirect with error message
            return redirect()
                ->route("welcome")
                ->with("error", "Invalid verification token.");
        }

        // Mark the user as verified
        $user->markEmailAsVerified();
        $user->remember_token = Str::random(40);
        $user->save();
        // Redirect the user after successful verification
        return redirect()
            ->route("customerloginpage")
            ->with("success", "Your email has been verified successfully, Login Now.");
    }

    //Forgot Password Page
    public function ForgotPasswordPage()
    {
        return view("frontend.Auth.ForgotPassword");
    }

    // Forgot Password Email Check In DataBase
    public function ForgotPassword(Request $request)
    {
        $user = User::where("email", "=", $request->email)->first();
        if (!empty($user)) {
            $user->remember_token = Str::random(40);
            $user->save();
            $verificationUrl = $user->remember_token;
            Mail::to($user->email)->send(
                new ForgotPasswordMail($user, $verificationUrl)
            );
            return redirect()
                ->back()
                ->with("success", "Please Check Your Email And reset password");
        } else {
            return redirect()
                ->back()
                ->with("error", "Email Not Found");
        }
    }

    //Reset Password Page
    public function reset($token)
    {
        $user = User::where("remember_token", "=", $token)->first();
        if (!empty($user)) {
            $data["user"] = $user;
            return view("frontend.Auth.reset");
        } else {
            abort(404);
        }
    }

    // Reset password Logic to Reset Password
    public function ResetPassword($token, Request $request)
    {
        $request->validate([
            "password" => "required|min:8",
        ]);
        $user = User::where("remember_token", "=", $token)->first();
        if (!empty($user)) {
            if ($request->password == $request->cpassword) {
                $user->password = Hash::make($request->password);
                if (empty($user->email_verified_at)) {
                    $user->email_verified_at = date("Y-m-d H:i:s");
                }
                $user->remember_token = Str::random(40);
                $user->save();
                return redirect()
                    ->route("customerloginpage")
                    ->with(
                        "success",
                        "Password Change Successfully You Can Login Now.."
                    );
            } else {
                return redirect()
                    ->back()
                    ->with("error", "Both Password Dose Not Match");
            }
        } else {
            abort(404);
        }
    }

    //Logout Function
    public function Customerlogout()
    {
        Session::flush();
        Auth::logout();
        return redirect(route("customerloginpage"))->with(
            "success",
            "Logout Successfully"
        );
    }
}
