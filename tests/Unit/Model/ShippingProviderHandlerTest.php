<?php

declare(strict_types=1);

namespace App\Tests\Unit\Model;

use App\Entity\Order;
use App\Model\ShippingProviderContext;
use App\Model\ShippingProviderHandler;
use PHPUnit\Framework\TestCase;
use Prophecy\Prophecy\ObjectProphecy;

class ShippingProviderHandlerTest extends TestCase
{
    /**
     * @var ShippingProviderContext|ObjectProphecy
     */
    private $shippingProviderContext;

    protected function setUp(): void
    {
        $this->shippingProviderContext = $this->prophesize(ShippingProviderContext::class);

        $this->shippingProviderHandler = new ShippingProviderHandler(
            $this->shippingProviderContext->reveal()
        );
    }

    public function testShouldCreateOrder(): void
    {
        $this->assertEquals($this->createOrder(), $this->shippingProviderHandler->createOrder());
    }

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
