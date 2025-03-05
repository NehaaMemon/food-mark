<?php

namespace App\Providers;

use App\Models\Setting;
use App\Services\SettingServices;
use Illuminate\Support\ServiceProvider;

class SettingServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(Setting::class,function(){
            return new SettingServices();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $settingService = $this->app->make(SettingServices::class);
        $settingService->setGlobalSettings();
    }
}
