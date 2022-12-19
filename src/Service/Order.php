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
            $postRequest = $this->httpClient->post($shippingRegisterUrl, $result);
            $response = $this->getResponse($postRequest);
        } catch (GuzzleException $e) {
            $response = ShipmentError::register($e->getMessage());
        }

        return $response;
    }

    #[ArrayShape(["message" => "string", "content" => ""])]
    public function getResponse($postRequest): array
    {
        return
            [
                "message" => self::SHIPMENT_REGISTERED_MESSAGE,
                "content" => $postRequest->getBody()->getContents(),
            ];
    }
}
