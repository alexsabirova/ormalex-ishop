<?php

declare(strict_types=1);

namespace Domain\Cart\StorageIdentities;

use Domain\Collections\CartIdentityStorageContract;

class SessionIdentityStorage implements CartIdentityStorageContract
{
    public function get(): string
    {
        return session()->getId();
    }
}
