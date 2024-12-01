<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        setLocale(LC_TIME, $this->app->getLocale());
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Blade::directive('uang', function ($nominal, $currency='IDR') {
            if ($currency == 'USD') return "$<?php echo number_format($nominal, 2); ?>";
            return "Rp <?php echo number_format($nominal, 2, ',', '.'); ?>";
        });
    }
}
