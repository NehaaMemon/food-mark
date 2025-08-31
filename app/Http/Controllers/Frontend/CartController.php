<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Response;

class CartController extends Controller
{
    function index() : View{
        return view('frontend.pages.cart-view');
    }

    function addtocart(Request $request){
        $products = Product::with(['productSizes','productOptions'])->findOrFail($request->product_id);
            if($products->quantity < $request->quantity){
                throw ValidationException::withMessages(['Quantity is not avaliable!']);
            }
        try{
        // dd($products);
        $productSize = $products->productSizes->where('id',$request->product_size)->first();
        $productOptions = $products->productOptions->whereIn('id',$request->product_option);

        $options = [
           'product_size' =>[],
           'productOption' => [],
           'productinfo' => [
            'image' => $products->thumb_image,
            'slug' => $products->slug
           ],
        ];

        if($productSize !== null){
        $options['product_size'] = [
         'id' => $productSize?->id,
         'name' => $productSize?->name,
         'price' => $productSize?->price
        ];
        }

        foreach( $productOptions as $option){
            $options['productOption'][] = [
                'id' => $option->id,
                'name' => $option->name,
                'price' => $option->price
            ];
        }
        Cart::add([
            'id' => $products->id,
            'name' => $products->name,
            'qty' => $request->quantity,
            'price' => $products->offer_price > 0 ? $products->offer_price : $products->price,
            'weight' => 0,
            'options' => $options
        ]);
        return response(['status' => 'success', 'message' => 'product added into cart'],200);
    }catch(\Exception $e){
        logger($e);
        return response(['status' => 'error', 'message' => 'Something went wrong'],500);

    }
    }
    function getCartProduct() {
        return view('frontend.layouts.ajax-files.sidebar-cart-item')->render();
    }
    function cartProductRemove($rowId){
        try{
            cart::remove($rowId);
            return response([
                'status' => 'success',
                'message' => 'remove successfully',
                'cart_total' => cartTotal(),
                'grand_cart_total' => grandCartTotal()
            ],200);
        }
        catch(\Exception $e){
            return response(['status' => 'error','message' => 'Something went wrong',500]);
        }
    }
    function cartqtyUpdate(Request $request) {
        $cartItem = Cart::get($request->rowId);
        $products = Product::findOrFail($cartItem->id);
            if($products->quantity < $request->qty){
               return response(['status' => 'error' , 'message' => 'quantity is not avaliable', 'qty' => $cartItem->qty]);
            }
        try{
           $cart =  Cart::update($request->rowId, $request->qty);
            return response([
                'status' => 'success',
                'product_total' => productTotal($request->rowId),
                'qty' =>  $cart->qty,
                'cart_total' => cartTotal(),
                'grand_cart_total' => grandCartTotal()
             ],200);
        }
        catch(\Exception $e){
            logger($e);
            return response(['status' => 'error', 'message' => 'Something went wrong.please page reload',500]);


        }
    }
    function CartDestroy(){
        Cart::destroy();
        session()->forget('coupon');
        return redirect()->back();
    }
}

