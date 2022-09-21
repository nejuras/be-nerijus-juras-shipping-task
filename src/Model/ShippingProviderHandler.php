<?php

declare(strict_types=1);

namespace App\Model;

use App\Entity\Order;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class ShippingProviderHandler implements MessageHandlerInterface
{
    private $shippingProviderContext;

    public function __construct(
        ShippingProviderContext $shippingProviderContext
    ) {
        $this->shippingProviderContext = $shippingProviderContext;
    }

    /**
     * @throws \Exception
     */
    public function __invoke(ShippingProvider $data): array
    {
        return $this->shippingProviderContext->handle($data, $this->createOrder());
    }

    public function createOrder(): Order
    {
        $order = new Order();
        $order->setId('10');
        $order->setPostCode('03214');
        $order->setCountry('Lithuania');
        $order->setCity('Vilnius');
        $order->setStreet('Mindaugo');

        return $order;
    }
}
