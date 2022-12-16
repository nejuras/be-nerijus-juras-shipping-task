<?php

namespace App\Model;

use App\Entity\Order;

interface StrategyInterface
{
    public function canProcess(ShippingProvider $data): bool;
    public function process(ShippingProvider $data, Order $order): array;
    public function createShipping(Order $order);
}