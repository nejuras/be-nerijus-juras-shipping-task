<?php

declare(strict_types=1);

namespace App\Tests\Unit\Model;

use App\Entity\Order;
use App\Model\ShippingProvider;
use App\Model\ShippingProvider\Dhl\DhlStrategy;
use App\Model\ShippingProvider\Omniva\OmnivaStrategy;
use App\Model\ShippingProvider\Ups\UpsStrategy;
use App\Model\ShippingProviderContext;
use PHPUnit\Framework\TestCase;
use Prophecy\Prophecy\ObjectProphecy;
use Prophecy\PhpUnit\ProphecyTrait;

class ShippingProviderContextTest extends TestCase
{
    use ProphecyTrait;

    private ShippingProviderContext|ObjectProphecy $shippingProviderContext;

    private ObjectProphecy|UpsStrategy $upsStrategy;

    private ObjectProphecy|OmnivaStrategy $omnivaStrategy;

    private ObjectProphecy|DhlStrategy $dhlStrategy;

    private Order $order;

    protected function setUp(): void
    {
        $this->omnivaStrategy = $this->prophesize(OmnivaStrategy::class);
        $this->dhlStrategy = $this->prophesize(DhlStrategy::class);
        $this->upsStrategy = $this->prophesize(UpsStrategy::class);

        $shippingProviderStrategies = [
            $this->omnivaStrategy->reveal(),
            $this->dhlStrategy->reveal(),
            $this->upsStrategy->reveal(),
        ];

        $this->order = $this->createOrder();

        $this->shippingProviderContext = new ShippingProviderContext($shippingProviderStrategies);
    }

    public function testShouldThrowExceptionForUnprocessableStrategy(): void
    {
        $data = new ShippingProvider('ups');

        $this->omnivaStrategy->canProcess($data)->shouldBeCalled()->willReturn(false);
        $this->dhlStrategy->canProcess($data)->shouldBeCalled()->willReturn(false);
        $this->upsStrategy->canProcess($data)->shouldBeCalled()->willReturn(false);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Can not process strategy with shipping provider key: ups');

        $this->shippingProviderContext->handle($data, $this->order);
    }

    /**
     * @throws \Exception
     */
    public function testShouldProcessUpsShippingProviderStrategy(): void
    {
        $upsShipping = [
            'ups' => [
                'zipCode' => '03210',
                'country' => 'Lithuania',
                'orderId' => 10,
                'city' => 'Vilnius',
                'street' => 'Mindaugo',
            ]
        ];

        $data = new ShippingProvider('ups');

        $this->omnivaStrategy->canProcess($data)->shouldBeCalled()->willReturn(false);
        $this->dhlStrategy->canProcess($data)->shouldBeCalled()->willReturn(false);
        $this->upsStrategy->canProcess($data)->shouldBeCalled()->willReturn(true);

        $this->upsStrategy->process($data, $this->order)->shouldBeCalled()->willReturn($upsShipping);

        $this->shippingProviderContext->handle($data, $this->order);
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
