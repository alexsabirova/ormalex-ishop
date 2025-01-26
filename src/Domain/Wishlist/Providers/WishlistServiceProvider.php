<?php

declare(strict_types=1);

namespace Domain\Wishlist\Providers;

use Domain\Wishlist\WishlistManager;
use Domain\Wishlist\Contracts\WishlistIdentityStorageContract;
use Domain\Wishlist\StorageIdentities\SessionIdentityStorage;
use Illuminate\Support\ServiceProvider;

class WishlistServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->register(
            ActionsServiceProvider::class
        );

        $this->app->bind(WishlistIdentityStorageContract::class, SessionIdentityStorage::class);

        $this->app->singleton(WishlistManager::class);
    }

    public function boot(): void
    {

    }
}
