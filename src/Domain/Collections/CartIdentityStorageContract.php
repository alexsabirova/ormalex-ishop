<?php

declare(strict_types=1);

namespace Domain\Collections;

interface CartIdentityStorageContract
{
    public function get(): string;
}
