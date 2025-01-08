<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Blade::directive('asset', function ($file) {
            return "<?php echo asset('assets/' . $file . '?v=' . config('app.version')); ?>";
        });

        Blade::directive('cssLink', function ($file) {
            return "<?php echo '<link href=\"' . asset('assets/' . $file . '?v=' .config('app.version')) . '\" rel=\"stylesheet\" />' . PHP_EOL; ?>";
        });

        Blade::directive('scriptLink', function ($file) {
            return "<?php echo '<script src=\"' . asset('assets/' . $file . '?v=' .config('app.version')) . '\"></script>' . PHP_EOL; ?>";
        });
    }
}
