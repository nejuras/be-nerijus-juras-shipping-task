<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Order;
use App\Model\ShippingProvider;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Serializer\SerializerInterface;

class ShippingProviderController extends AbstractController
{
    use HandleTrait;

    public function __construct(
        MessageBusInterface $messageBus
    ) {
        $this->messageBus = $messageBus;
    }

    public function registerShipping(SerializerInterface $serializer): Response
    {
        $result = $this->handle(new ShippingProvider((new Order())->getShippingProviderKey()));

        return new Response($serializer->serialize($result, 'json'), Response::HTTP_CREATED);
    }
}
