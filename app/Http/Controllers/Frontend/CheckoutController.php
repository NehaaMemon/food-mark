<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\DeliveryArea;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    function index(){
        $addresses = Address::where(['user_id'=> auth()->user()->id])->get();
        $deliveryAreas = DeliveryArea::where('status',1)->get();
        return view('frontend.pages.checkout',compact('addresses','deliveryAreas'));
    }
    function calculatedelivery(string $id){
     try{
        $address = Address::findOrFail($id);
        $delivery_fee = $address->deliveryArea?->delivery_fee;
        $grand_total = grandCartTotal($delivery_fee)  ;
        return response(['delivery_fee' =>  $delivery_fee,'grand_total' =>  $grand_total]);
     }
     catch(\Exception $e){
        logger($e);
          return response(['message' =>  'Something Went Wrong',422]);
     }
    }
    function checkoutRedirect(Request $request) {
       $request->validate([
        'id' => ['required','integer']
       ]);
       $address = Address::with('deliveryArea')->findOrFail($request->id);
       $selectedAddress = $address->address.'Area :'.$address->deliveryArea?->area_name;
       session()->put('address',$selectedAddress);
       session()->put('delivery_fee' ,$address->deliveryArea?->delivery_fee);
       session()->put('address_id',$address->id);
       return response(['redirect_url' => route('payment.index')]);
    }
}
