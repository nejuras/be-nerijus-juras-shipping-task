<?php

declare(strict_types=1);

namespace App\Entity;

class Order
{
    private string $id;

    private string $street;

    private string $postCode;

    private string $city;

    private string $country;

    /**
     * Shipping provider key.
     * Other options might be `dhl`, `omniva`
     * Feel free to modify this
     */
    public function getShippingProviderKey(): string
    {
        return 'omniva';
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function getStreet(): string
    {
        return $this->street;
    }

    public function setStreet(string $street): void
    {
        $this->street = $street;
    }

    public function getPostCode(): string
    {
        return $this->postCode;
    }

    public function setPostCode(string $postCode): void
    {
        $this->postCode = $postCode;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function setCity(string $city): void
    {
        $this->city = $city;
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
