<?php

declare(strict_types=1);

namespace App\Model;

class ShippingProvider
{
    private $shippingProviderKey;

    public function __construct(
        $shippingProviderKey
    ) {
        $this->shippingProviderKey = $shippingProviderKey;
    }

    public function getShippingProviderKey(): string
    {
        return $this->shippingProviderKey;
    }

}
