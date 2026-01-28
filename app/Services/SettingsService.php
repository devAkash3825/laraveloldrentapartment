<?php
namespace App\Services;

use App\Models\Setting;
use Cache;

class SettingsService {

    function getSettings() {
        return Cache::rememberForever('settings', function(){
            return Setting::pluck('value', 'key')->toArray();
        });
    }

    function setGlobalSettings() {
        $settings = $this->getSettings();
        config()->set('settings', $settings);

        if (isset($settings['mail_host']) && config('app.env') !== 'local') {
            config()->set('mail.default', $settings['mail_driver'] ?? 'smtp');
            config()->set('mail.mailers.smtp.host', $settings['mail_host']);
            config()->set('mail.mailers.smtp.port', $settings['mail_port']);
            config()->set('mail.mailers.smtp.encryption', $settings['mail_encryption']);
            config()->set('mail.mailers.smtp.username', $settings['mail_username']);
            config()->set('mail.mailers.smtp.password', $settings['mail_password']);
            config()->set('mail.from.address', $settings['mail_from_address']);
            config()->set('mail.from.name', $settings['mail_from_name'] ?? config('app.name'));
        } else if (isset($settings['mail_host'])) {
            \Log::info('Mail settings override skipped because APP_ENV is local. Using .env settings.');
        }
    }

    function clearCachedSettings() {
        Cache::forget('settings');
    }
}
