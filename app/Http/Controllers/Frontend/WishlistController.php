<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use Auth;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class WishlistController extends Controller
{
   function store(string $productId) : Response {

    $productWishlist = Wishlist::where(['user_id' => auth()->user()->id , 'product_id' => $productId])->exists();

    if($productWishlist){
        throw ValidationException::withMessages(['Product already in wishlist']);
    }

    if(!Auth::check()){
         throw ValidationException::withMessages(['Please login for wishlist this product']);
    }

    $wishlist = new Wishlist();
    $wishlist->user_id = auth()->user()->id;
    $wishlist->product_id = $productId;
    $wishlist->save();

    return response(['status' => 'success','message' => 'product in your Wishlist!']);

   }
}
