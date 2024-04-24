<?php

namespace App\Http\Controllers;
use App\Models\Transaction;

use Illuminate\Http\Request;

use App\Mail\OrderCanceledMail;
use App\Models\TransactionDetail;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class OrderManagementController extends Controller
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
    // Show index page of OrderManagement
    public function OrderManagement()
    {
        $this->checkUserRole();
        return view("admin.OrderManagement.index");
    }

    public function transactions()
    {
        $transactions = Transaction::orderBy('created_at', 'desc')->get(); 
        return response()->json($transactions);
    }

    // View transaction
    public function ViewTransaction($id)
    {
        $id = base64_decode($id);
        $this->checkUserRole();
        // Find the transaction with the given ID
        $transaction = Transaction::find($id);
        
        if ($transaction) {
            // Include the details of the transaction
            $transactionDetails = TransactionDetail::where('transaction_id', $id)
                ->with('product:id,name', 'transaction:id,created_at')
                ->get();
            
            return view("admin.OrderManagement.viewtransaction", compact("transaction", "transactionDetails"));
        } else {
            return response()->json([
                "status" => "error",
                "message" => "Transaction not found",
            ]);
        }
    }

    // edit ProductCategory details
    public function EditTransaction($id)
    {
        $id = base64_decode($id);
        $this->checkUserRole();

        $transaction = Transaction::find($id);

        if ($transaction) {
            // Include the details of the transaction
            $transactionDetails = TransactionDetail::where('transaction_id', $id)
                ->with('product:id,name', 'transaction:id,created_at')
                ->get();
            return view("admin.OrderManagement.editorder",compact("transaction", "transactionDetails"));
        } else {
            return response()->json([
                "status" => "error",
                "message" => "Transaction Not Found",
            ]);
        }
    }

   // Update Transaction details
    public function UpdateTransaction(Request $request, $id)
    {
        $id = base64_decode($id);
        $this->checkUserRole();

        $transaction = Transaction::find($id);

        if (!$transaction) {
            return redirect()
                ->route("OrderManagement")
                ->with("error", "Transaction not found");
        }

        // Check if the current status is 'Accepted'
        if ($transaction->order_status === 'Accepted') {
            return redirect()
                ->route("OrderManagement")
                ->with("error", "Transaction status cannot be reverted from 'Accepted'");
        }

        $request->validate([
            "order_status" => "required|string",
        ]);

        // Get the old status before updating
        $oldStatus = $transaction->order_status;

        // Update status
        $transaction->order_status = $request->input("order_status");
        $transaction->save();

        // If the new status is 'Canceled', send an email to the user
        if ($transaction->order_status === 'Canceled') {
            // Retrieve user email
            $userEmail = $transaction->email;

            // Retrieve transaction details
            $transactionDetails = TransactionDetail::where('transaction_id', $id)
                ->with('product:id,name', 'transaction:id,created_at')
                ->get();

            // Send email
            Mail::to($userEmail)->send(new OrderCanceledMail($transaction, $transactionDetails));
        }

        return redirect()
            ->route("OrderManagement")
            ->with("success", "Transaction Status updated successfully");
    }

}
