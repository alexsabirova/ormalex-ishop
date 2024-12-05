<?php

namespace App\Providers;

use App\Events\AfterSessionRegenerated;
use Domain\Cart\CartManager;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Event;
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
        Model::shouldBeStrict(!app()->isProduction());

        Event::listen(
            AfterSessionRegenerated::class, function (AfterSessionRegenerated $event) {
            app(CartManager::class)->updateStorageId(
                $event->old,
                $event->current
            );
        });
    }
}
