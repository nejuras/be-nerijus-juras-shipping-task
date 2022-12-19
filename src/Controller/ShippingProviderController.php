<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\ShippingProvider;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Serializer\SerializerInterface;

class ShippingProviderController extends AbstractController
{
    use HandleTrait;

    public function __construct(
        MessageBusInterface $messageBus,
    ) {
        $this->messageBus = $messageBus;
    }

    public function registerShipping(Request $request, SerializerInterface $serializer): Response
    {
        $shippingProviderDataData = $this->getShippingProviderData($request);

        $result = $this->handle($shippingProviderDataData);

        return new Response($serializer->serialize($result, 'json'), Response::HTTP_CREATED);
    }


    public function getShippingProviderData(Request $request): ShippingProvider
    {
        $data = json_decode($request->getContent(), true);

        return new ShippingProvider($data['shippingProviderKey']);
    }
}
