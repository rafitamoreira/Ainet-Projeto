<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use DB;

class StatisticsController extends Controller
{
    public function ordersPerMonth()
    {
        $ordersPerMonth = Order::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('COUNT(*) as count')
        )
            ->where('created_at', '>=', Carbon::now()->subYear())
            ->groupBy('month')
            ->get();

        return response()->json($ordersPerMonth);
    }

    public function averageOrderValue()
    {
        $averageOrderValue = Order::where('created_at', '>=', Carbon::now()->subYear())
            ->average('total_price');

        return response()->json(['average_order_value' => $averageOrderValue]);
    }

    public function registeredUsers()
    {
        $usersCount = User::count();

        return response()->json(['registered_users' => $usersCount]);
    }

    public function revenuePerMonth()
    {
        $revenuePerMonth = Order::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('SUM(total_price) as total')
        )
            ->where('created_at', '>=', Carbon::now()->subYear())
            ->groupBy('month')
            ->get();

        return response()->json($revenuePerMonth);
    }


    
    public function orderStatusCount()
    {
        $statuses = ['pending', 'paid', 'closed', 'canceled'];
        $counts = [];

        foreach ($statuses as $status) {
            $counts[$status] = Order::where('status', $status)->count();
        }

        return response()->json($counts);
    }

    // TODO: Implement other statistics and improve the existing ones...
}