<?php

declare(strict_types=1);

namespace App\Model;

use App\Model\ShippingProvider\ShippingProviderEnum;
use Symfony\Component\Validator\Constraints as Assert;

class ShippingProviderConstraints
{
    public function constraints(): Assert\Collection
    {
        return new Assert\Collection([
                'shippingProviderKey' => [
                    new Assert\Choice(
                        ShippingProviderEnum::list()
                    ),
                ],
            ]
        );
    }
}
