<?php

declare(strict_types=1);

namespace Domain\Wishlist\StorageIdentities;


use Domain\Wishlist\Contracts\WishlistIdentityStorageContract;

class SessionIdentityStorage implements WishlistIdentityStorageContract
{
    public function get(): string
    {
        return session()->getId();
    }
}
