<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\OrderDataTable;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class OrderController extends Controller
{
    function index(OrderDataTable $datatable) : View|JsonResponse{
        return $datatable->render('admin.orders.index');

    }

    function show($id) : View {
        $order = Order::findOrFail($id);
        return view('admin.orders.show',compact('order'));

    }
}
