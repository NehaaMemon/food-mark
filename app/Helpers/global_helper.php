<?php

//generate Unique Slug//
if (!function_exists('generateUniqueSlug')) {
    function generateUniqueSlug($model, $name): string
    {
        $modelClass = "App\\Models\\$model";
        if (!class_exists($modelClass)) {
            throw new \InvalidArgumentException("Model $model not found");
        }
        $slug = \Str::slug($name);
        $count = 2;
        while ($modelClass::where('slug', $slug)->exists()) {
            $slug = \Str::slug($name) . '-' . $count;
            $count++;
        }
        return $slug;
    }
    if (!function_exists('currency_position')) {
        function currencyPosition($price): string
        {
            if (config('settings.site_default_currency_position') === 'left') {
                return config('settings.site_default_currency_icon') . $price;
            } else {
                return $price . config('settings.site_default_currency_icon');
            }
        }
    }
}
// calculate cart total price //
if (!function_exists('cartTotal')) {
    function cartTotal()
    {
        $totalPrice = 0;
        foreach (Cart::content() as $item) {
            $productprice = $item->price;
            $sizePrice = $item->options?->product_size['price'] ?? 0;
            $optionsPrice = 0;
            foreach ($item->options->productOption as $option) {
                $optionsPrice += $option['price'];
            }
            $totalPrice += number_format(($productprice + $sizePrice +  $optionsPrice) * $item->qty,2);
        }
        return $totalPrice;
    }
}
//calculate product total price//
if(!function_exists('productTotal')){
    function productTotal($rowId){
        $total = 0;
        $product = Cart::get($rowId);
        $productPrice = $product->price;
        $sizePrice = $product->options?->product_size['price'] ?? 0;
        $optionsPrice = 0;

        foreach($product->options->productOption as $option){
            $optionsPrice += $option['price'];

        }
        $total += number_format(($productPrice + $sizePrice + $optionsPrice) * $product->qty,2);
        return $total;
    }

}

//grand cart total//
if(!function_exists('grandCartTotal')){
    function grandCartTotal($deliveryFee = 0){
        $total = 0;
        $carttotal = cartTotal();

        if(session()->has('coupon')){
            $discount = session()->get('coupon')['discount'];
            $total = number_format(($carttotal  + $deliveryFee) - $discount,2);
            return $total;
        }
        else{
            $total = number_format(($carttotal  + $deliveryFee),2);
            return $total;
        }
    }
}
//Create Unique Invoice Id//
if(!function_exists('generateInvoiceId')){
    function generateInvoiceId() {

        $randomNumber = rand(1,9999);
        $currentTimeDate = now();
        $invoiceId = $randomNumber .  $currentTimeDate->format('ymd').$currentTimeDate->format('s');
        return $invoiceId;
    }

}

//get product discout in percenyage//
if(!function_exists('discountInPercentage')){
    function discountInPercentage($orignalprice, $offerprice){
        $discount = (($orignalprice - $offerprice) / $orignalprice) * 100;
        return round($discount , 2);


    }

    if(!function_exists('setSidebar')){
        function setSidebar(array $route) {
            if(request()->routeIs($route)){
                return 'active';
            }
            return '';
        }
    }

}
