<?php

declare(strict_types=1);

namespace Domain\Wishlist\StorageIdentities;


use Domain\Wishlist\Contracts\WishlistIdentityStorageContract;

class FakeIdentityStorage implements WishlistIdentityStorageContract
{
    public function get(): string
    {
        return 'fake';
    }
}
