<?php

declare(strict_types=1);

namespace App\Model\ShippingProvider\Dhl;

use App\Entity\Order;
use App\Model\ShippingProvider;
use App\Model\ShippingProvider\ShippingProviderEnum;
use App\Model\StrategyInterface;
use App\Service\Order as OrderEntity;
use JetBrains\PhpStorm\ArrayShape;

class DhlStrategy implements StrategyInterface
{
    private const SHIPPING_REGISTER_URL = 'https://dhlfake.com/register';

    public function __construct(private readonly OrderEntity $orderEntity)
    {
    }

    public function canProcess(ShippingProvider $data): bool
    {
        return $data->getShippingProviderKey() === ShippingProviderEnum::DHL->value;
    }

    public function process(ShippingProvider $data, Order $order): array
    {
        $shipping = $this->createShipping($order);

        $result = $this->buildRegisterShippingProviderResult($shipping);

        return $this->orderEntity->registerShipping(self::SHIPPING_REGISTER_URL, $result);
    }

    public function createShipping(Order $order): Dhl
    {
        return (new Dhl())
            ->setPostCode('03218')
            ->setOrderId((int)$order->getId())
            ->setCountry('Lithuania')
            ->setCity('Kaunas')
            ->setStreet('Algirdo');
    }

    #[ArrayShape([
        'postCode' => "mixed",
        'country' => "mixed",
        'city' => "mixed",
        'orderId' => "mixed",
        'street' => "mixed",
    ])]
    public function buildRegisterShippingProviderResult($dhlShipping): array
    {
        return
            [
                'postCode' => $dhlShipping->getPostCode(),
                'country' => $dhlShipping->getCountry(),
                'city' => $dhlShipping->getCity(),
                'orderId' => $dhlShipping->getOrderId(),
                'street' => $dhlShipping->getStreet(),
            ];
    }
}