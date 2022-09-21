<?php

declare(strict_types=1);

namespace App\Model\ShippingProvider\Omniva;

use App\Entity\Order;
use App\Model\ShippingProvider;
use App\Model\StrategyInterface;

class OmnivaStrategy implements StrategyInterface
{
    public const OMNIVA = 'omniva';

    public function canProcess(ShippingProvider $data): bool
    {
        return $data->getShippingProviderKey() === self::OMNIVA;
    }

    public function process(ShippingProvider $data, Order $order): array
    {
        $omnivaShipping = $this->registerShipping($order);

        $omniva[self::OMNIVA] = [
            'postCode' => $omnivaShipping->getPostCode(),
            'country' => $omnivaShipping->getCountry(),
            'orderId' => $omnivaShipping->getOrderId(),
            'pickUpPointId' => $omnivaShipping->getPickUpPointId(),
        ];
        return $omniva;
    }

    public function registerShipping(Order $order): Omniva
    {
        $omniva = new Omniva();
        $omniva->setPostCode('03210');
        $omniva->setOrderId((int)$order->getId());
        $omniva->setCountry('Lithuania');
        $omniva->setPickUpPointId('1');

        return $omniva;
    }
}