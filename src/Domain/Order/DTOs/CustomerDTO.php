<?php

declare(strict_types=1);

namespace Domain\Order\DTOs;

use Support\Traits\Makeable;

class CustomerDTO
{
    use Makeable;

    public function __construct(
        public readonly string $first_name,
        public readonly string $last_name,
        public readonly string $email,
        public readonly string $phone,
        public readonly string $city,
        public readonly string $address,
    )
    {
    }

    public function fullName(): string
    {
        return trim($this->first_name . ' ' . $this->last_name);
    }

    public static function fromArray(array $data): self
    {
        return self::make(
            $data['first_name'] ?? '',
            $data['last_name'] ?? '',
            $data['email'] ?? '',
            $data['phone'] ?? '',
            $data['city'] ?? '',
            $data['address'] ?? '',
        );
    }

    public function toArray(): array
    {
        return [
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'phone' => $this->phone,
            'city' => $this->city,
            'address' => $this->address,
        ];
    }
}
