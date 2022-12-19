<?php

declare(strict_types=1);

namespace App\Model;

class ShippingProvider
{
    public function __construct(
        private readonly string $shippingProviderKey,
    ) {
    }

    public function getShippingProviderKey(): string
    {
        return $this->shippingProviderKey;
    }

}
