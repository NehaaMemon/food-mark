<?php
namespace App\Services;

use App\Models\Setting;
use Cache;

class SettingServices{

  function getSettings() {
    return Cache::rememberForever('settings',function(){
       return Setting::pluck('value','key')->toArray();

    });
}
    function setGlobalSettings() : void{
      $settings = $this->getSettings();
      config()->set('settings', $settings);
    }

    function ClearCachedSettings() : void{
        Cache::forget('settings');
    }

}
