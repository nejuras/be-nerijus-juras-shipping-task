<?php

declare(strict_types=1);

namespace App\Model;

use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class ShippingProviderHandler implements MessageHandlerInterface
{
    private $shippingProviderContext;
    private $order;

    public function __construct(
        ShippingProviderContext $shippingProviderContext,
        MockOrder $order
    ) {
        $this->shippingProviderContext = $shippingProviderContext;
        $this->order = $order;
    }

    /**
     * @throws \Exception
     */
    public function __invoke(ShippingProvider $data): array
    {
        return $this->shippingProviderContext->handle($data, $this->order->createOrder());
    }
}
