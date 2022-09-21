<?php

declare(strict_types=1);

namespace App\Model\ShippingProvider\Omniva;

use App\Entity\Order;
use App\Model\ShippingProvider;
use App\Model\StrategyInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class OmnivaStrategy extends AbstractController implements StrategyInterface
{
    public const OMNIVA = 'omniva';

    public function canProcess(ShippingProvider $data): bool
    {
        return $data->getShippingProviderKey() === self::OMNIVA;
    }

    public function process(ShippingProvider $data, Order $order): array
    {
        $omnivaShipping = $this->registerShipping($order);

        $this->redirect($this->generateShippingProviderUrl($omnivaShipping));

        $omniva[self::OMNIVA] = self::buildRegisterShippingProviderResult($omnivaShipping);

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

    public static function buildRegisterShippingProviderResult($omnivaShipping): array
    {
        return
            [
                'postCode' => $omnivaShipping->getPostCode(),
                'country' => $omnivaShipping->getCountry(),
                'orderId' => $omnivaShipping->getOrderId(),
                'pickUpPointId' => $omnivaShipping->getPickUpPointId(),
            ];
    }

    public function generateShippingProviderUrl($omnivaShipping): string
    {
        return 'omnivafake.com/register?' . http_build_query(self::buildRegisterShippingProviderResult($omnivaShipping));
    }
}