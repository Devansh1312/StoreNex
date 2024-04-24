<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class OrderReportController extends Controller
{
    // Check User Role
    private function checkUserRole()
    {
        $user = Auth::user();
        if (!$user || !in_array($user->role, [1, 2])) {
            abort(403, "Unauthorized access. You do not have the necessary role to access this!");
        }
    }

    // Show index page of OrderManagement
    public function OrderReports()
    {
        $this->checkUserRole();
        return view("admin.OrderReport.index");
    }

    public function Orders(Request $request)
    {
        // Fetch all transactions initially
        $transactions = Transaction::orderBy('id', 'desc');

        
        // Retrieve transactions
        $transactions = $transactions->get();

        return response()->json($transactions);
    }

}
