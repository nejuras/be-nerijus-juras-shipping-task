<?php

declare(strict_types=1);

namespace App\Model\ShippingProvider\Omniva;

use App\Entity\Order;
use App\Model\Exception\ShipmentError;
use App\Model\ShippingProvider;
use App\Model\StrategyInterface;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;

class OmnivaStrategy implements StrategyInterface
{
    public const OMNIVA = 'omniva';
    private const URL = 'https://omnivafake.com';
    private const PATH = '/register';

    private ClientInterface $httpClient;

    public function __construct()
    {
        $this->httpClient = new Client();
    }

    public function canProcess(ShippingProvider $data): bool
    {
        return $data->getShippingProviderKey() === self::OMNIVA;
    }

    public function process(ShippingProvider $data, Order $order): array
    {
        $shipping = $this->registerShipping($order);

        return $this->getShippingData($shipping);
    }

    public function registerShipping(Order $order): Omniva
    {
        $omniva = new Omniva();
        $omniva->setPostCode('03210');
        $omniva->setOrderId((int)$order->getId());
        $omniva->setCountry('Lithuania');
        $omniva->setPickUpPointId('1');

        return $omniva;
    }

    public static function buildRegisterShippingProviderResult($shipping): array
    {
        return
            [
                'postCode' => $shipping->getPostCode(),
                'country' => $shipping->getCountry(),
                'orderId' => $shipping->getOrderId(),
                'pickUpPointId' => $shipping->getPickUpPointId(),
            ];
    }

    public function generateShippingProviderUrl(): string
    {
        return self::URL . self::PATH;
    }

    private function getShippingData($shipping): array
    {
        $url = $this->generateShippingProviderUrl();
        try {
            $post = $this->httpClient->post($url, self::buildRegisterShippingProviderResult($shipping));

            $response = $this->getResponse($post);

        } catch (GuzzleException $e) {
            $response = ShipmentError::register($e->getMessage());
        }

        return $response;
    }

    private function getResponse($post): array
    {
        return
            [
                "message" => "Shipment registered!",
                "content" => $post->getBody()->getContents(),
            ];
    }
}