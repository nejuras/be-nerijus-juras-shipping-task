<?php

declare(strict_types=1);

namespace App\Model;

class ShippingProviderContext
{
    private array $strategies = [];

    public function __construct(
        iterable $shippingProviderStrategies,
    ) {
        foreach ($shippingProviderStrategies as $shippingProviderStrategy) {
            $this->addStrategy($shippingProviderStrategy);
        }
    }

    public function addStrategy(StrategyInterface $strategy): void
    {
        $this->strategies[] = $strategy;
    }

    public function handle($data, $order): array
    {
        foreach ($this->strategies as $strategy) {
            if ($strategy->canProcess($data)) {
                return $strategy->process($data, $order);
            }
        }

        $this->throwUnprocessableStrategyException($data);
    }

    private function throwUnprocessableStrategyException(ShippingProvider $data): void
    {
        throw new \RuntimeException(
            "Can not process strategy with shipping provider key: " . $data->getShippingProviderKey()
        );
    }
}