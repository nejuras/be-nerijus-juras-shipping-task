<?php

declare(strict_types=1);

namespace App\Model\ShippingProvider\Dhl;

use App\Entity\Order;
use App\Model\ShippingProvider;
use App\Model\StrategyInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DhlStrategy extends AbstractController implements StrategyInterface
{
    public const DHL = 'dhl';

    public function canProcess(ShippingProvider $data): bool
    {
        return $data->getShippingProviderKey() === self::DHL;
    }

    public function process(ShippingProvider $data, Order $order): array
    {
        $dhlShipping = $this->registerShipping($order);

        $this->redirect($this->generateShippingProviderUrl($dhlShipping));

        $dhl[self::DHL] = self::buildRegisterShippingProviderResult($dhlShipping);

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

    public static function buildRegisterShippingProviderResult($dhlShipping): array
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

    public function generateShippingProviderUrl($dhlShipping): string
    {
        return 'dhlfake.com/register?' . http_build_query(self::buildRegisterShippingProviderResult($dhlShipping));
    }
}