<?php

declare(strict_types=1);

namespace Domain\Cart\StorageIdentities;


use Domain\Cart\Contracts\CartIdentityStorageContract;

class FakeIdentityStorage implements CartIdentityStorageContract
{
    public function get(): string
    {
        return 'fake';
    }
}
