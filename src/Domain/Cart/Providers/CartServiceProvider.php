<?php

declare(strict_types=1);

namespace Domain\Cart\Providers;

use Domain\Cart\CartManager;
use Domain\Cart\StorageIdentities\SessionIdentityStorage;
use Domain\Catalog\Providers\ActionsServiceProvider;
use Domain\Collections\CartIdentityStorageContract;
use Illuminate\Support\ServiceProvider;

class CartServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->register(
            ActionsServiceProvider::class
        );

        $this->app->bind(CartIdentityStorageContract::class, SessionIdentityStorage::class);

        $this->app->singleton(CartManager::class);
    }

    public function boot(): void
    {

    }
}
