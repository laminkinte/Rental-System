<?php

namespace App\Providers;

use App\Models\SiteSetting;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Set default string length for MySQL
        Schema::defaultStringLength(191);

        // Dynamic Site Settings Blade Directive
        Blade::directive('setting', function ($key) {
            return "<?php echo App\Models\SiteSetting::get({$key}); ?>";
        });

        Blade::directive('site', function ($key) {
            return "<?php echo App\Models\SiteSetting::get('{$key}'); ?>";
        });

        Blade::if('setting', function ($key, $value = null) {
            if ($value !== null) {
                return SiteSetting::get($key) == $value;
            }
            return (bool) SiteSetting::get($key);
        });
    }
}
