<?php
namespace App\Services;

use App\Models\PaymentGatewaySetting;
use Cache;

class paymentGatewaySettingService{

    function getSettings(){
        return Cache::rememberForever('paymentSettings',function() {
            return PaymentGatewaySetting::pluck('value','key');
        });
    }

    function setGlobalSettings() : void {
        $setting = $this->getSettings();
        config()->set('paymentSettings',$setting);

    }
    function clearCacheSettings() : void {
        Cache::forget('paymentSettings');

    }
}


?>
