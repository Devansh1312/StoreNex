<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class OrderReportController extends Controller
{
    private function checkUserRole()
    {
        $user = Auth::user();
        if (!$user || !in_array($user->role, [1, 2])) {
            abort(403, "Unauthorized access. You do not have the necessary role to access this!");
        }
    }

    public function OrderReports()
    {
        $this->checkUserRole();
        return view("admin.OrderReport.index");
    }

    public function Orders(Request $request)
    {
        $this->checkUserRole();
        $orderStatus = $request->input('order_status');
        $status = $request->input('status');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Log::info('Order Status: ' . $orderStatus);
        // Log::info('Paymet Status: ' . $status);
        // Log::info('Start Date: ' . $startDate);
        // Log::info('End Date: ' . $endDate);

        $query = Transaction::query();

        // Apply filter by order status
        if (!empty($orderStatus)) {
            $query->where('order_status', $orderStatus);
        }

        // Apply filter by order status
        if (!empty($status)) {
            $query->where('status', $status);
        }

        if (!empty($startDate) && !empty($endDate)) {
            // Adjusting start and end dates to cover transactions on April 18, 2024 to April 25, 2024
            $formattedStartDate = date('Y-m-d 00:00:00', strtotime($startDate));
            $formattedEndDate = date('Y-m-d 23:59:59', strtotime($endDate));
            $query->whereBetween('created_at', [$formattedStartDate, $formattedEndDate]);
        }

        $transactions = $query->get();

        // Log the SQL query with actual values
        $queryStr = $query->toSql();
        foreach ($query->getBindings() as $binding) {
            $queryStr = preg_replace('/\?/', "'$binding'", $queryStr, 1);
        }
        // Log::info('Query Executed: ' . $queryStr);

        // Log::info('Number of Transactions: ' . $transactions->count()); // Log the number of transactions retrieved

        return response()->json($transactions);
    }
}
