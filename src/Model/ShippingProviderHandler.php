<?php

declare(strict_types=1);

namespace App\Model;

use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use JMS\Serializer\ArrayTransformerInterface;

class ShippingProviderHandler implements MessageHandlerInterface
{
    public function __construct(
        private readonly ShippingProviderContext $shippingProviderContext,
        private readonly MockOrder $order,
        protected ValidatorInterface $validator,
        protected ShippingProviderConstraints $shippingProviderConstraints,
        private readonly ArrayTransformerInterface $arrayTransformer,
    ) {
    }

    public function __invoke(ShippingProvider $data)
    {
        $errors = $this->validator->validate(
            $this->arrayTransformer->toArray($data),
            $this->shippingProviderConstraints->constraints(),
        );

        if ($errors->count()) {
            return $errors[0]->getMessage();
        }

        return $this->shippingProviderContext->handle($data, $this->order->createOrder());
    }
}
