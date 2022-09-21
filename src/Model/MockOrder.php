<?php

declare(strict_types=1);

namespace App\Model;

use App\Entity\Order;

class MockOrder
{
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
