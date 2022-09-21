<?php

declare(strict_types=1);

namespace App\Model\ShippingProvider\Ups;

use App\Entity\Order;
use App\Model\ShippingProvider;
use App\Model\StrategyInterface;

class UpsStrategy implements StrategyInterface
{
    public const UPS = 'ups';

    public function canProcess(ShippingProvider $data): bool
    {
        return $data->getShippingProviderKey() === self::UPS;
    }

    public function process(ShippingProvider $data, Order $order): array
    {
        $register = $this->registerShipping($order);
        $ups[self::UPS] = [
            'zipCode' => $register->getZipCode(),
            'country' => $register->getCountry(),
            'city' => $register->getCity(),
            'orderId' => $register->getOrderId(),
            'street' => $register->getStreet(),
        ];
        return $ups;
    }

    public function registerShipping(Order $order): Ups
    {
        $ups = new Ups();
        $ups->setAddress('Mindaugo g. 27');
        $ups->setOrderId((int)$order->getId());
        $ups->setCountry('Lithuania');
        $ups->setTown('Vilnius');
        $ups->setZipCode('03225');

        return $ups;
    }
}