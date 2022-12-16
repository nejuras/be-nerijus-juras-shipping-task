<?php

declare(strict_types=1);

namespace App\Service;

use App\Model\Exception\ShipmentError;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use JetBrains\PhpStorm\ArrayShape;

class Order
{
    private ClientInterface $httpClient;
    private const SHIPMENT_REGISTERED_MESSAGE = "Shipment registered!";

    public function __construct()
    {
        $this->httpClient = new Client();
    }

    public function registerShipping($shippingRegisterUrl, $result): array
    {
        try {
            $post = $this->httpClient->post($shippingRegisterUrl, $result);

            $response = $this->getResponse($post);
        } catch (GuzzleException $e) {
            $response = ShipmentError::register($e->getMessage());
        }

        return $response;
    }

    #[ArrayShape(["message" => "string", "content" => ""])]
    private function getResponse($post): array
    {
        return
            [
                "message" => self::SHIPMENT_REGISTERED_MESSAGE,
                "content" => $post->getBody()->getContents(),
            ];
    }
}
