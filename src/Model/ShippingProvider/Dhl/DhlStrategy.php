<?php

declare(strict_types=1);

namespace App\Model\ShippingProvider\Dhl;

use App\Entity\Order;
use App\Model\ShippingProvider;
use App\Model\StrategyInterface;

class DhlStrategy implements StrategyInterface
{
    public const DHL = 'dhl';

    public function canProcess(ShippingProvider $data): bool
    {
        return $data->getShippingProviderKey() === self::DHL;
    }

    public function process(ShippingProvider $data, Order $order): array
    {
        $dhlShipping = $this->registerShipping($order);

        $dhl[self::DHL] = [
            'postCode' => $dhlShipping->getPostCode(),
            'country' => $dhlShipping->getCountry(),
            'city' => $dhlShipping->getCity(),
            'orderId' => $dhlShipping->getOrderId(),
            'street' => $dhlShipping->getStreet(),
        ];
        return $dhl;
    }

    public function registerShipping(Order $order): Dhl
    {
        $dhl = new Dhl();
        $dhl->setPostCode('03218');
        $dhl->setOrderId((int)$order->getId());
        $dhl->setCountry('Lithuania');
        $dhl->setCity('Kaunas');
        $dhl->setStreet('Algirdo');

        return $dhl;
    }
}