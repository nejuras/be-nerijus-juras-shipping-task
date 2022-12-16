<?php

declare(strict_types=1);

namespace App\Model\ShippingProvider\Omniva;

use App\Entity\Order;
use App\Service\Order as OrderEntity;
use App\Model\ShippingProvider;
use App\Model\StrategyInterface;

class OmnivaStrategy implements StrategyInterface
{
    public const OMNIVA = 'omniva';
    private const SHIPPING_REGISTER_URL = 'https://omnivafake.com/register';

    public function __construct(private readonly OrderEntity $orderEntity)
    {
    }

    public function canProcess(ShippingProvider $data): bool
    {
        return $data->getShippingProviderKey() === self::OMNIVA;
    }

    public function process(ShippingProvider $data, Order $order): array
    {
        $shipping = $this->createShipping($order);

        $result = $this->buildRegisterShippingProviderResult($shipping);

        return $this->orderEntity->registerShipping(self::SHIPPING_REGISTER_URL, $result);
    }

    public function createShipping(Order $order): Omniva
    {
        return (new Omniva())
            ->setPostCode('03210')
            ->setOrderId((int)$order->getId())
            ->setCountry('Lithuania')
            ->setPickUpPointId('1');
    }

    public function buildRegisterShippingProviderResult($shipping): array
    {
        return
            [
                'postCode' => $shipping->getPostCode(),
                'country' => $shipping->getCountry(),
                'orderId' => $shipping->getOrderId(),
                'pickUpPointId' => $shipping->getPickUpPointId(),
            ];
    }
}