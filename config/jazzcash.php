<?php
return [


    'environment'     => env('JAZZCASH_ENVIRONMENT', 'sandbox'),
    'sandbox_url'     => env('JAZZCASH_SANDBOX_URL'), // Should be correct as per .env
    'live_url'        => env('JAZZCASH_LIVE_URL'),
    'merchant_id'     => env('JAZZCASH_MERCHANT_ID'),
    'password'        => env('JAZZCASH_PASSWORD'),
    'integerity_salt'  => env('JAZZCASH_INTEGERITY_SALT'),
    'return_url'      => env('JAZZCASH_RETURN_URL'),




    // 'environment' => env('JAZZCASH_ENVIRONMENT', 'sandbox'),
    // 'sandbox_url' => 'https://sandbox.jazzcash.com.pk/CustomerPortal/TransactionManagement/MerchantForm/',
    // 'live_url'    => 'https://payments.jazzcash.com.pk/CustomerPortal/TransactionManagement/MerchantForm/',
    // 'merchant_id' => env('JAZZCASH_MERCHANT_ID'),
    // 'password'    => env('JAZZCASH_PASSWORD'),

    // 'integerity_salt' => env('JAZZCASH_INTEGERITY_SALT'),
    // 'return_url'  => env('JAZZCASH_RETURN_URL'),
];


