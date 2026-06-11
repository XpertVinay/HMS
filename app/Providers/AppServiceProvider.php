<?php

namespace App\Providers;

use App\Listeners\DeleteExpiredFcmTokens;
use App\Services\FirebaseCredentialsService;
use App\Services\PushNotificationService;
use Illuminate\Notifications\Events\NotificationFailed;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(PushNotificationService::class);
        $this->app->singleton(FirebaseCredentialsService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Force HTTPS for all asset URLs to resolve Mixed Content issues
        // We use a direct host check to bypass all proxy header and .env issues
        if (request()->getHost() !== 'localhost' && request()->getHost() !== '127.0.0.1') {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }

        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        Event::listen(NotificationFailed::class, DeleteExpiredFcmTokens::class);

        $this->app->booted(function (): void {
            try {
                app(FirebaseCredentialsService::class)->applyToConfig();
            } catch (\Throwable) {
                // Database may be unavailable during install/migrate.
            }
        });

        \Illuminate\Support\Facades\Validator::extend('email_domain', function ($attribute, $value, $parameters, $validator) {
            $allowedDomains = ['gmail.com', 'yahoo.com', 'outlook.com', 'hotmail.com', 'businzo.com'];
            $domain = strtolower(substr(strrchr($value, "@"), 1));
            return empty($allowedDomains) || in_array($domain, $allowedDomains);
        }, 'Please enter an email with an allowed domain.');

        \Illuminate\Support\Facades\Validator::extend('alpha_space', function ($attribute, $value, $parameters, $validator) {
            if (!is_string($value))
                return false;
            return preg_match('/^[a-zA-Z\s]+$/', $value);
        }, 'The :attribute may only contain letters and spaces.');

        \Illuminate\Support\Facades\Validator::extend('alpha_numeric_special', function ($attribute, $value, $parameters, $validator) {
            if (!is_string($value))
                return false;
            return preg_match('/^[a-zA-Z0-9\s,\-\/\(\)]+$/', $value);
        }, 'The :attribute may only contain alphanumeric characters, spaces, and the symbols , - / ( ).');

        \Illuminate\Support\Facades\Validator::resolver(function ($translator, $data, $rules, $messages, $customAttributes) {
            foreach ($rules as $field => &$fieldRules) {
                // Ensure $fieldRules is an array for easier manipulation
                if (is_string($fieldRules)) {
                    $fieldRules = explode('|', $fieldRules);
                } elseif (!is_array($fieldRules)) {
                    continue;
                }

                $fieldLower = strtolower($field);

                if (($fieldLower === 'name' || $fieldLower === 'first_name' || $fieldLower === 'last_name' || str_contains($fieldLower, 'name')) && !str_contains($fieldLower, 'username') && !str_contains($fieldLower, 'file')) {
                    $fieldRules[] = 'alpha_space';
                }
                if (str_contains($fieldLower, 'address') || str_contains($fieldLower, 'location')) {
                    $fieldRules[] = 'alpha_numeric_special';
                }
                if ($fieldLower === 'email' || str_contains($fieldLower, 'email')) {
                    $fieldRules[] = 'email_domain';
                }
                if ($fieldLower === 'phone' || str_contains($fieldLower, 'mobile') || str_contains($fieldLower, 'contact')) {
                    $fieldRules[] = 'regex:/^[0-9]+$/';
                }
                if (in_array($fieldLower, ['image', 'logo', 'document', 'file', 'avatar', 'attachment', 'upload'])) {
                    // Avoid adding file rules if the field is just a string URL or similar, but typically these are files
                    // We only apply if the field is present in data and is an uploaded file
                    if (isset($data[$field]) && $data[$field] instanceof \Illuminate\Http\UploadedFile) {
                        $fieldRules[] = 'mimes:jpg,jpeg,png,pdf,docs,docx,csv,json';
                        $fieldRules[] = 'max:5120';
                    }
                }

                $fieldRules = array_unique($fieldRules);
            }

            return new \Illuminate\Validation\Validator($translator, $data, $rules, $messages, $customAttributes);
        });
    }
}
