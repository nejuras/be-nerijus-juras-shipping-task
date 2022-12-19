<?php

declare(strict_types=1);

namespace App\Model;

use App\Model\ShippingProvider\ShippingProviderEnum;
use App\Service\Validator\ValidatorConstraintsInterface;
use Symfony\Component\Validator\Constraints as Assert;

class ShippingProviderConstraints implements ValidatorConstraintsInterface
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
