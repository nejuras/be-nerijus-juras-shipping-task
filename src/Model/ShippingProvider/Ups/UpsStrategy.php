<?php

declare(strict_types=1);

namespace App\Model\ShippingProvider\Ups;

use App\Entity\Order;
use App\Model\ShippingProvider;
use App\Model\StrategyInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UpsStrategy extends AbstractController implements StrategyInterface
{
    public const UPS = 'ups';

    public function canProcess(ShippingProvider $data): bool
    {
        return $data->getShippingProviderKey() === self::UPS;
    }

    public function process(ShippingProvider $data, Order $order): array
    {
        $upsShipping = $this->registerShipping($order);

        $this->redirect($this->generateShippingProviderUrl($upsShipping));

        $ups[self::UPS] = self::buildRegisterShippingProviderResult($upsShipping);

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

    public static function buildRegisterShippingProviderResult($upsShipping): array
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

    public function generateShippingProviderUrl($upsShipping): string
    {
        return 'upsfake.com/register?' . http_build_query(self::buildRegisterShippingProviderResult($upsShipping));
    }
}