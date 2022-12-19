<?php

declare(strict_types=1);

namespace App\Model\ShippingProvider\Ups;

use App\Entity\Order;
use App\Model\ShippingProvider;
use App\Model\ShippingProvider\ShippingProviderEnum;
use App\Model\StrategyInterface;
use App\Service\Order as OrderEntity;
use JetBrains\PhpStorm\ArrayShape;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UpsStrategy extends AbstractController implements StrategyInterface
{
    private const SHIPPING_REGISTER_URL = 'https://upsfake.com/register';

    public function __construct(private readonly OrderEntity $orderEntity)
    {
    }

    public function canProcess(ShippingProvider $data): bool
    {
        return $data->getShippingProviderKey() === ShippingProviderEnum::UPS->value;
    }

    public function process(ShippingProvider $data, Order $order): array
    {
        $shipping = $this->createShipping($order);

        $result = $this->buildRegisterShippingProviderResult($shipping);

        return $this->orderEntity->registerShipping(self::SHIPPING_REGISTER_URL, $result);
    }

    public function createShipping(Order $order): Ups
    {
        return (new Ups())
            ->setAddress('Mindaugo g. 27')
            ->setOrderId((int)$order->getId())
            ->setCountry('Lithuania')
            ->setTown('Vilnius')
            ->setZipCode('03225');
    }

    #[ArrayShape([
        'zipCode' => "mixed",
        'country' => "mixed",
        'city' => "mixed",
        'orderId' => "mixed",
        'street' => "mixed"
    ])]
    public function buildRegisterShippingProviderResult($upsShipping): array
    {
        return
            [
                'zipCode' => $upsShipping->getZipCode(),
                'country' => $upsShipping->getCountry(),
                'city' => $upsShipping->getCity(),
                'orderId' => $upsShipping->getOrderId(),
                'street' => $upsShipping->getStreet(),
            ];
    }
}