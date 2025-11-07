<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\TodayOrderDataTable;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderPlacedNotification;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    function index(TodayOrderDataTable $datatable) : View|JsonResponse
    {
        $totalOrder = Order::count();
        $todayOrder = Order::whereDate('created_at',now()->format('d m Y'))->count();
        $thisMonth = Order::whereMonth('created_at',now()->month)->count();
        $totalEarning = Order::where('order_status','delivered')->sum('grand_total');
        return $datatable->render('admin.dashboard.index',compact('totalOrder','todayOrder','totalEarning','thisMonth'));

    }

    function clearNotification() {
        $notification = OrderPlacedNotification::query()->update(['seen'=>1]);
        toastr()->success('All notifications cleared successfully');
        return redirect()->back();
    }
}
