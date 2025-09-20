<?php
 namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;
use Cart;


class orderService{
    // Store Order In Database//
     function CreateOrder() {
    try{

            $order = new Order();
            $order->invoice_id = generateInvoiceId();
            $order->user_id = auth()->user()->id;
            $order->address = session()->get('address');
           $discount = session()->get('coupon')['discount'] ?? 0;
            $order->discount = $discount;
            $order->delivery_charge = session()->get('delivery_fee');
            $order->subtotal = cartTotal();
            $order->grand_total = grandCartTotal(session()->get('delivery_fee'));
            $order->product_qty = Cart::content()->count();
            $order->payment_method = Null;
            $order->payment_status = 'pending';
            $order->payment_approve_date = Null;
            $order->transection_id = Null;
            $order->coupon_info = json_encode(session()->get('coupon'));
            $order->currency_name = Null;
            $order->order_status = 'pending';
             $order->address_id = session()->get('address_id');
            $order->save();
            foreach(Cart::content() as $product){
                $orderItem = new OrderItem();
                $orderItem->order_id = $order->id;
                $orderItem->product_name = $product->name;
                $orderItem->product_id = $product->id;
                $orderItem->unit_price = $product->price;
                $orderItem->qty = $product->qty;
                $orderItem->product_size = json_encode($product->options->product_size);
                $orderItem->product_option = json_encode($product->options->productOption);
                $orderItem->save();
            }
              //get order id of using session//
            session()->put('order_id',$order->id);
            //get amount of using session//
            session()->put('grand_total',$order->grand_total);
            return true;

    }
    catch(\Exception $e){
        logger($e);
        return false;
    }
    }




    function clearSession()  {
        \Cart::destroy();
        session()->forget('coupon');
        session()->forget('address');
        session()->forget('delivery_fee');
        session()->forget('delivery_order_id');
        session()->forget('order_id');
        session()->forget('grand_total');
    }
}

?>
