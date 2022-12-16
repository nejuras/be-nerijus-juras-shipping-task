<?php

declare(strict_types=1);

namespace App\Model;

use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class ShippingProviderHandler implements MessageHandlerInterface
{
    public function __construct(
        private readonly ShippingProviderContext $shippingProviderContext,
        private readonly MockOrder $order
    ) {
    }

    /**
     * @throws \Exception
     */
    public function __invoke(ShippingProvider $data): array
    {
        return $this->shippingProviderContext->handle($data, $this->order->createOrder());
    }
}
