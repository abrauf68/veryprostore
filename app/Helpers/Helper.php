<?php

namespace App\Helpers;

use App\Models\BusinessSetting;
use App\Models\Cart;
use App\Models\CompanySetting;
use App\Models\Order;
use App\Models\ProductCategory;
use App\Models\SystemSetting;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\WithdrawalRequest;
use Carbon\Carbon;

class Helper
{
    public static function dashboard_route()
    {
        $user = User::find(Auth::user()->id);
        $route = $user->role->role . '.dashboard';
        return $route;
    }
    public static function getLogoLight()
    {
        return CompanySetting::first()->light_logo ?? asset('frontAssets/images/veryprostore.png');
    }
    public static function getLogoDark()
    {
        return CompanySetting::first()->dark_logo ?? asset('frontAssets/images/veryprostore_dark.png');
    }
    public static function getFavicon()
    {
        return CompanySetting::first()->favicon ?? asset('frontAssets/images/veryprostorefav.png');
    }
    public static function getCompanyName()
    {
        return CompanySetting::first()->company_name ?? env('APP_NAME');
    }
    public static function getCompanyPhone()
    {
        $companySetting = CompanySetting::with('country')->first();
        if ($companySetting->country) {
            $companyPhone = $companySetting->country->phone_code . $companySetting->phone_number;
            return $companyPhone;
        } else {
            $companyPhone = '+1' . $companySetting->phone_number;
            return $companyPhone;
        }
    }
    public static function getCompanyEmail()
    {
        return CompanySetting::first()->email ?? 'test@gmail.com';
    }
    public static function getCompanyCity()
    {
        return CompanySetting::first()->city ?? 'New York';
    }
    public static function getCompanyZip()
    {
        return CompanySetting::first()->zip ?? '12345';
    }
    public static function getCompanyAddress()
    {
        return CompanySetting::first()->address ?? 'Suite #05 Beacon Street';
    }
    public static function getCompanyCountry()
    {
        if (isset(CompanySetting::first()->country)) {
            return CompanySetting::first()->country->name;
        } else {
            return "United States";
        }
    }
    public static function getTimezone()
    {
        $systemSetting = SystemSetting::with('timezone')->first();
        return $systemSetting->timezone->name ?? env('APP_TIMEZONE', 'UTC');
    }
    public static function getDefaultLanguage()
    {
        $systemSetting = SystemSetting::with('language')->first();
        return $systemSetting->language->iso_code ?? 'en';
    }
    public static function getfooterText()
    {
        return SystemSetting::first()->footer_text ?? 'All Copyrights Reserved';
    }
    public static function getMaxUploadSize()
    {
        $sizeInKB = SystemSetting::first()->max_upload_size ?? 2048; // Stored in KB

        return self::humanReadableSize($sizeInKB * 1024); // Convert KB to Bytes
    }

    // Helper function to format size into KB, MB, GB, etc.
    public static function humanReadableSize($bytes, $decimals = 2)
    {
        $sizes = ['B', 'KB', 'MB', 'GB', 'TB'];
        $factor = floor((strlen($bytes) - 1) / 3);

        return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . $sizes[$factor];
    }


    // example use of currency format {{ \App\Helpers\Helper::formatCurrency($price) }}
    public static function formatCurrency($amount)
    {
        $currencySetting = SystemSetting::first();

        if (!$currencySetting) {
            return $amount; // Return the amount as is if settings are not found
        }

        $symbol = $currencySetting->currency_symbol;
        $position = $currencySetting->currency_symbol_position; // 'prefix' or 'postfix'

        if ($position === 'prefix') {
            return $symbol . number_format($amount);
        }

        return number_format($amount) . $symbol;
    }

    public static function renderRecaptcha($formId, $action = 'register')
    {
        if (config('captcha.version') === 'v3') {
            return self::renderRecaptchaV3($formId, $action);
        }
    }

    private static function renderRecaptchaV3($formId, $action)
    {
        $siteKey = config('captcha.sitekey');
        return <<<HTML
            <script src="https://www.google.com/recaptcha/enterprise.js?render={$siteKey}"></script>
            <script>
                function handleRecaptcha(formId, action) {
                    document.getElementById(formId).addEventListener('submit', function(e) {
                        e.preventDefault();
                        grecaptcha.enterprise.ready(async () => {
                            try {
                                const token = await grecaptcha.enterprise.execute('{$siteKey}', { action: action });
                                const form = document.getElementById(formId);
                                const input = document.createElement('input');
                                input.type = 'hidden';
                                input.name = 'g-recaptcha-response';
                                input.value = token;
                                form.appendChild(input);
                                form.submit();
                            } catch (error) {
                                console.error('Error executing reCAPTCHA:', error);
                            }
                        });
                    });
                }

                document.addEventListener('DOMContentLoaded', function() {
                    handleRecaptcha('{$formId}', '{$action}');
                });
            </script>
        HTML;
    }

    public static function getCategories()
    {
        $categories = ProductCategory::where('is_active', 'active')
            ->where('parent_category_id', null)
            ->with('children')
            ->get();

        return $categories;
    }

    public static function getCart()
    {
        if (Auth::check()) {
            $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);
        } else {
            $sessionId = session('cart_session_id');
            $cart = Cart::firstOrCreate(['session_id' => $sessionId]);
        }

        // Eager load relations after ensuring cart exists
        return $cart->load('items.product');
    }

    public static function getVendorOrders()
    {
        $currentUser = User::findOrFail(auth()->user()->id);
        if (!($currentUser->hasRole('admin') || $currentUser->hasRole('super-admin'))) {
            $ordersCount = Order::whereHas('orderItems.product', function ($q) use ($currentUser) {
                $q->where('vendor_id', $currentUser->id);
            })->whereIn('status', ['pending', 'shipped'])->count();
        } else {
            $ordersCount = Order::whereIn('status', ['pending', 'shipped'])->count();
        }

        // Eager load relations after ensuring cart exists
        return $ordersCount;
    }

    public static function getWithdrawRequests()
    {
        $currentUser = User::findOrFail(auth()->user()->id);
        if (!($currentUser->hasRole('admin') || $currentUser->hasRole('super-admin'))) {
            $withdrawalRequests = WithdrawalRequest::with('user')->where('user_id', $currentUser->id)->whereIn('status', ['pending', 'inprogress'])->count();
        } else {
            $withdrawalRequests = WithdrawalRequest::with('user')->whereIn('status', ['pending', 'inprogress'])->count();
        }

        // Eager load relations after ensuring cart exists
        return $withdrawalRequests;
    }
}
