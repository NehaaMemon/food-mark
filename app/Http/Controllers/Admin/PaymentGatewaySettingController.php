<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentGatewaySetting;
use App\Services\paymentGatewaySettingService;
use App\Traits\fileuploadtriat;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PaymentGatewaySettingController extends Controller
{
    use fileuploadtriat;

    function index(): View
    {
        $paymentSetting = PaymentGatewaySetting::pluck('value', 'key');
        return view('admin.payment-setting.index', compact('paymentSetting'));
    }
    function paypalSettingUpdate(Request $request)
    {
        $validatedData = $request->validate([
            'paypal_status' => ['required', 'boolean'],
            'paypal_account_mode' => ['required', 'in:sandbox,live'],
            'paypal_country' => ['required',],
            'paypal_currency_name' => ['required'],
            'paypal_rate' => ['required', 'numeric'],
            'paypal_api_key' => ['required'],
            'paypal_secret_key' => ['required'],
            'paypal_app_id' => ['required']

        ]);
        if ($request->hasFile('paypal_logo')) {
            $request->validate([
                'paypal_logo' => ['nullable', 'image']
            ]);
            $imagePath = $this->uploadImage($request, 'paypal_logo');
            PaymentGatewaySetting::updateOrCreate(
                ['key' => 'paypal_logo'],
                ['value' => $imagePath]
            );
        }
        foreach ($validatedData as $key => $value) {
            PaymentGatewaySetting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }
        $paymentSettingServices = app(paymentGatewaySettingService::class);
        $paymentSettingServices->clearCacheSettings();

        toastr()->success('Updated Successfully');
        return redirect()->back();
    }

    function stripeSettingUpdate(Request $request)
    {
        $validatedData = $request->validate([
            'stripe_status' => ['required', 'boolean'],
            'stripe_country' => ['required'],
            'stripe_currency_name' => ['required'],
            'stripe_rate' => ['required', 'numeric'],
            'stripe_api_key' => ['required'],
            'stripe_secret_key' => ['required'],


        ]);
        if ($request->hasFile('stripe_logo')) {
            $request->validate([
                'stripe_logo' => ['nullable', 'image']
            ]);
            $imagePath = $this->uploadImage($request, 'stripe_logo');
            PaymentGatewaySetting::updateOrCreate(
                ['key' => 'stripe_logo'],
                ['value' => $imagePath]
            );
        }
        foreach ($validatedData as $key => $value) {
            PaymentGatewaySetting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }
        $paymentSettingServices = app(paymentGatewaySettingService::class);
        $paymentSettingServices->clearCacheSettings();

        toastr()->success('Updated Successfully');
        return redirect()->back();
    }

    function jazzcashSettingUpdate(Request $request)
    {
        $validatedData = $request->validate([
            'jazzcash_status' => ['required', 'boolean'],
            'jazzcash_account_mode' => ['required', 'in:sandbox,live'],
            'jazzcash_country' => ['required', 'in:Pakistan,pakistan'],
            'jazzcash_currency_name' => ['required', 'in:PKR,pkr'],
            'jazzcash_rate' => ['required', 'numeric'],
            'jazzcash_merchant_id' => ['required', 'string'],
            'jazzcash_password' => ['required', 'string'],
            'jazzcash_integerity_salt' => ['required', 'string'],
        ]);

        if ($request->hasFile('jazzcash_logo')) {
            $request->validate([
                'jazzcash_logo' => ['nullable', 'image']
            ]);
            $imagePath = $this->uploadImage($request, 'jazzcash_logo');
            PaymentGatewaySetting::updateOrCreate(
                ['key' => 'jazzcash_logo'],
                ['value' => $imagePath]
            );
        }
        foreach ($validatedData as $key => $value) {
            PaymentGatewaySetting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }
        $paymentSettingServices = app(paymentGatewaySettingService::class);
        $paymentSettingServices->clearCacheSettings();

        toastr()->success('Updated Successfully');
        return redirect()->back();
    }
}
