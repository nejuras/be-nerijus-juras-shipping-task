<?php

declare(strict_types=1);

namespace App\Model;

use App\Service\Validator\Validator;
use App\Service\Validator\ValidatorConstraintsInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class ShippingProviderHandler implements MessageHandlerInterface
{
    public function __construct(
        private readonly ShippingProviderContext $shippingProviderContext,
        private readonly MockOrder $order,
        protected Validator $validator,
        protected ValidatorConstraintsInterface $validatorConstraints,
    ) {
    }

    public function __invoke(ShippingProvider $data): array
    {
        $this->validator->validate(
            $data,
            $this->validatorConstraints,
        );

        return $this->shippingProviderContext->handle($data, $this->order->createOrder());
    }
}
