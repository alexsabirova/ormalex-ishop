<?php

declare(strict_types=1);

namespace Domain\Wishlist\Contracts;

interface WishlistIdentityStorageContract
{
    public function get(): string;
}
