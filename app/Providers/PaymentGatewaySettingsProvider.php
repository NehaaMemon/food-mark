<?php

namespace App\Providers;

use App\Services\paymentGatewaySettingService;
use Illuminate\Support\ServiceProvider;

class PaymentGatewaySettingsProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(paymentGatewaySettingService::class,function(){
            return new paymentGatewaySettingService();

        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
       $paymentGatewaySetting = $this->app->make(paymentGatewaySettingService::class);
       $paymentGatewaySetting->setGlobalSettings();

    }
}
