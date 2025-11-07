<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\DeclinedOrderDataTable;
use App\DataTables\DeliveredOrderDataTable;
use App\DataTables\InProcessOrderDataTable;
use App\DataTables\OrderDataTable;
use App\DataTables\PendingOrderDataTable;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderPlacedNotification;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class OrderController extends Controller
{
    function index(OrderDataTable $datatable) : View|JsonResponse{
        return $datatable->render('admin.orders.index');
    }

     function pendingOrders(PendingOrderDataTable $datatable) : View|JsonResponse{
        return $datatable->render('admin.orders.pending-orders-index');
    }

      function inProcessOrders(InProcessOrderDataTable $datatable) : View|JsonResponse{
        return $datatable->render('admin.orders.inprocess-orders');
    }

         function DeliveredOrders(DeliveredOrderDataTable $datatable) : View|JsonResponse{
          return $datatable->render('admin.orders.delivered-orders');
     }

         function DeclinedOrders(DeclinedOrderDataTable $datatable) : View|JsonResponse{
          return $datatable->render('admin.orders.declined-orders');
     }

    function show($id) : View {
        $order = Order::findOrFail($id);
        $notification = OrderPlacedNotification::where('order_id',$order->id)->update(['seen'=> 1]);
        return view('admin.orders.show',compact('order'));

    }

    function getOrderStatus(string $id) : Response {
        $order = Order::select(['order_status','payment_status'])->findOrFail($id);
        return response($order);

    }

    function orderStatusUpdate(Request $request, string $id) : RedirectResponse|Response {

        $request->validate([
            'payment_status' => ['required','in:pending,completed'],
            'order_status' => ['required','in:pending,in_process,delivered,declined']
        ]);

        $order = Order::findOrFail($id);
        $order->payment_status = $request->payment_status;
        $order->order_status = $request->order_status;
        $order->save();

        if($request->ajax()){
            return response(['message'=> 'Order Status Updated!']);
        }
        else{
            toastr()->success('Order Updated');
            return redirect()->back();
        }
    }

    function destroy(string $id) : Response {
      try{
          $order = Order::findOrFail($id);
          $order->delete();
          return response(['status' => 'success', 'message' => 'Deleted Successfully']);
      }
      catch(\Exception $e){
        logger($e);
        return response(['status' => 'error', 'message' => 'Something went wrong']);
      }
    }
}
