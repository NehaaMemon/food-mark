<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Mail\ContactMail;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\DailyOffer;
use App\Models\Product;
use App\Models\ProductRating;
use App\Models\Reservation;
use App\Models\Slider;
use App\Models\Subscriber;
use App\Models\TitleSection;
use App\Models\WhyChooseUs;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View as ViewView;

class FrontendController extends Controller
{
    function index(): View
    {
        $titleSection = $this->getTitleSection();
        $sliders = Slider::where('status', 1)->get();
        $whyChooseUs = WhyChooseUs::where('status', 1)->get();
        $categories = Category::where(['show_at_home' => 1 , 'status' => 1])->get();
        $dailyOffer = DailyOffer::with('product')->where('status',1)->take(10)->get();


        return view('frontend.home.index', compact(
            'sliders',
             'titleSection',
              'whyChooseUs',
              'categories',
              'dailyOffer'
            ));
    }


function about() : View {
    $whyChooseUs = WhyChooseUs::where('status', 1)->get();
    return view('frontend.pages.about',compact('whyChooseUs'));

}

function contact() : View {
    return view('frontend.pages.contact');

}

function chef() : View {
    return view('frontend.pages.chef');
}

function gallery() : View {
    return view('frontend.pages.gallery');
}

function contactSendMessage(Request $request)  {
   $request->validate([
    'name' => ['required','max:50'],
    'email' => ['required','max:255'],
    'message' => ['required','max:1000']
   ]);

   Mail::send(new ContactMail($request->name,$request->email,$request->message));
   return response(['status' => 'success','message' => 'Message Send Successsfully!']);
}


    function getTitleSection(): Collection
    {
        $keys =  [
            'why_choose_us_top_title',
            'why_choose_us_main_title',
            'why_choose_us_sub_title'
        ];
        return TitleSection::whereIn('key', $keys)->pluck('value', 'key');
    }
    function showProduct(string $slug) : View{
        $product = Product::with(['ProductImages','productSizes','productOptions'])
        ->where(['slug' => $slug ,'status' => 1])
         ->withAvg('reviews','rating')
        ->withCount('reviews')
        ->firstorfail();
        $relatedProducts = Product::where('category_id',$product->category_id)
        ->where('id','!=',$product->id)->take(8)->latest()->get();
        $reviews = ProductRating::where(['product_id' => $product->id , 'status' => 1])->paginate(10);
        return view('frontend.pages.product-view',compact('product','relatedProducts','reviews'));
    }

    function products(Request $request) : View {
        $products = Product::where(['status' => 1])->orderby('id','DESC');

        if($request->has('search') && $request->filled('search')){
            $products->where(function($query) use ($request){
                $query->where('name','like', '%' .$request->search. '%')
                    ->orWhere('long_description','like','%'.$request->search.'%');
            });
  }
          if($request->has('category') && $request->filled('category')){
            $products->whereHas('category', function($query) use ($request){
                $query->where('slug', $request->category);
            });
          }
          $products = $products->withAvg('reviews','rating')->withCount('reviews')
        ->paginate(12);

        $categories = Category::where('status',1)->get();
        return view('frontend.pages.product',compact('products','categories'));
    }

    function loadProductModal($productId){
       $product = Product::with('productSizes','productOptions')
       ->withAvg('reviews','rating')
       ->withCount('reviews')
       ->findOrFail($productId);
      return view('frontend.layouts.ajax-files.product-load-modal',compact('product'))->render();
    }

    function productReviewStore(Request $request)  {
         $request->validate([
        'rating' => ['required','integer','min:1','max:5'],
        'review' => ['required','max:500'],
        'product_id' => ['required','integer']
    ]);

    $user = Auth::user();

    $purchValidation = $user->orders()->whereHas('orderItems', function($query) use ($request){
        $query->where('product_id',$request->product_id);
    })
    ->where('order_status','delivered')
    ->get();


    if(count($purchValidation)== 0){
      throw ValidationException::withMessages([
        'review' => 'Please buy product then review!',]);
    }

    $alreadyReview = ProductRating::where(['user_id' => $user->id , 'product_id' => $request->product_id])
    ->exists();

    if($alreadyReview){
        throw ValidationException::withMessages(['You already Review this Product']);
    }

    $review = new ProductRating();
    $review->user_id = $user->id;
    $review->product_id = $request->product_id;
    $review->rating = $request->rating;
    $review->review = $request->review;
    $review->status = 0;
    $review->save();

    toastr()->success('Review Added Successfully');

    return redirect()->back();


    // auth()->user()->rating()->create([
    //     'rating' => $validated['rating'],
    // ]);

    // return back()->with('success', 'Rating submitted successfully!');
    }

    function applyCoupon(Request $request) {
        $subtotal = $request->subtotal;
        $code = $request->code;
       $coupon = Coupon::where('code',$request->code)->first();

       if(!$coupon){
        return response(['message' => 'Invalid Coupon Code!'],422);
       }
       if($coupon->quantity <= 0){
        return response(['message' => 'Coupon has been fully redeemed'],422);
    }
    if($coupon->expiry_date < now()){
        return response(['message' => 'Coupon has expired'],422);
    }
    if($coupon->discount_type === 'precent'){
        $discount = number_format($subtotal * ($coupon->discount / 100),2);
    }
    elseif($coupon->discount_type === 'amount'){
        $discount = number_format($coupon->discount,2);
    }
    $finalTotal = $subtotal - $discount;

    session()->put('coupon',['code' => $code, 'discount' => $discount]);

    return response(['message' => 'Coupon Applied Successfully','discount' => $discount,'finalTotal' => $finalTotal,'coupon_code' => $code]);
}

function destroyCoupon(){
   try{
    session()->forget('coupon');
    return response (['message' => 'Coupon Deleted','grand_cart_total' => grandCartTotal()]);
   }
   catch(\Exception $e){
logger($e);
return response (['message' => 'Something went Wrong']);
   }
}

public function reservation(Request $request)  {
   $request->validate([
    'name' => ['required','max:255'],
    'phone' => ['required','max:50'],
    'date' => ['required','date'],
    'time' => ['required'],
    'person' => ['required','numeric']
   ]);

   if(!Auth::check()){
    throw ValidationException::withMessages(["Please Login to request reservation"]);
   }

   $reservation = new Reservation();
   $reservation->reservation_id = rand(0,50000);
   $reservation->user_id = auth()->user()->id;
   $reservation->name = $request->name;
   $reservation->phone = $request->phone;
   $reservation->date = $request->date;
   $reservation->time = $request->time;
   $reservation->person = $request->person;
   $reservation->status = 'pending';
   $reservation->save();

   return response(['status' => 'success','message' => 'Request Send Successfully']);
 }

 function subscribeNewsletter(Request $request)  {
    $request->validate([
        'email' => ['required','email','max:255','unique:subscribers,email'
    ],['email.uniques' => 'Email is Already Subscribed']
    ]);

    $subscribe = new Subscriber();
    $subscribe->email = $request->email;
    $subscribe->save();

    return Response(['status' => 'success','message'=> 'Email Subscribed!']);

 }
}
