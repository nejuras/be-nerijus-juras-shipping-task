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

    public function setOrderId(int $orderId): self
    {
        $this->orderId = $orderId;

        return $this;
    }

    public function getPickUpPointId(): string
    {
        return $this->pickUpPointId;
    }

    public function setPickUpPointId(string $pickUpPointId): self
    {
        $this->pickUpPointId = $pickUpPointId;

        return $this;
    }

    public function getPostCode(): string
    {
        return $this->postCode;
    }

    public function setPostCode(string $postCode): self
    {
        $this->postCode = $postCode;

        return $this;
    }

    public function getCountry(): string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }
}
