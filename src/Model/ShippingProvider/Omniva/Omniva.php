<?php

declare(strict_types=1);

namespace App\Model\ShippingProvider\Omniva;

class Omniva
{
    private int $orderId;

    private string $pickUpPointId;

    private string $postCode;

    private string $country;

    public function getOrderId(): int
    {
        return $this->orderId;
    }

    public function setOrderId(int $orderId): void
    {
        $this->orderId = $orderId;
    }

    public function getPickUpPointId(): string
    {
        return $this->pickUpPointId;
    }

    public function setPickUpPointId(string $pickUpPointId): void
    {
        $this->pickUpPointId = $pickUpPointId;
    }

    public function getPostCode(): string
    {
        return $this->postCode;
    }

    public function setPostCode(string $postCode): void
    {
        $this->postCode = $postCode;
    }

    public function getCountry(): string
    {
        return $this->country;
    }

    public function setCountry(string $country): void
    {
        $this->country = $country;
    }
}
