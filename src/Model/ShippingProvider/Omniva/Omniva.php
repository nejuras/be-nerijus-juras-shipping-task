<?php

declare(strict_types=1);

namespace App\Model\ShippingProvider\Omniva;

class Omniva
{
    /** @var integer */
    private $orderId;

    /** @var string */
    private $pickUpPointId;

    /** @var string */
    private $postCode;

    /** @var string */
    private $country;

    /**
     * @return integer
     */
    public function getOrderId(): int
    {
        return $this->orderId;
    }

    /**
     * @param integer $orderId
     */
    public function setOrderId(int $orderId): void
    {
        $this->orderId = $orderId;
    }

    /**
     * @return string
     */
    public function getPickUpPointId(): string
    {
        return $this->pickUpPointId;
    }

    /**
     * @param string $pickUpPointId
     */
    public function setPickUpPointId(string $pickUpPointId): void
    {
        $this->pickUpPointId = $pickUpPointId;
    }

    /**
     * @return string
     */
    public function getPostCode(): string
    {
        return $this->postCode;
    }

    /**
     * @param string $postCode
     */
    public function setPostCode(string $postCode): void
    {
        $this->postCode = $postCode;
    }

    /**
     * @return string
     */
    public function getCountry(): string
    {
        return $this->country;
    }

    /**
     * @param string $country
     */
    public function setCountry(string $country): void
    {
        $this->country = $country;
    }
}
