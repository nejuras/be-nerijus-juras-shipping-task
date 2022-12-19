<?php

declare(strict_types=1);

namespace App\Tests\Unit\Model;

use App\Service\Order;
use PHPUnit\Framework\TestCase;

class OrderServiceTest extends TestCase
{
    private Order $orderOmniva;

    private const OMNIVA_URL = 'https://omnivafake.com/register';
    private const REGISTER_MESSAGE = 'Shipment is not registered!';

    protected function setUp(): void
    {
        $this->orderOmniva = new Order();
    }

    public function testShouldNotRegisterShippingWithWrongUrl(): void
    {
        $orderOmniva = $this->orderOmniva->registerShipping(self::OMNIVA_URL, $this->result());
        $this->assertEquals(self::REGISTER_MESSAGE, $orderOmniva['message']);
    }

    public function result(): array
    {
        return
            [
                'postCode' => '3256',
                'country' => 'Lithuania',
                'orderId' => '1',
                'pickUpPointId' => '2',
            ];
    }
}
