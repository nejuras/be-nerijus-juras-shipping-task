<?php

declare(strict_types=1);

namespace App\Model;

class ShippingProviderContext
{
    private $strategies = [];

    public function __construct(
        iterable $shippingProviderStrategies
    ) {
        foreach ($shippingProviderStrategies as $shippingProviderStrategy) {
            $this->addStrategy($shippingProviderStrategy);
        }
    }

    public function addStrategy(StrategyInterface $strategy)
    {
        $this->strategies[] = $strategy;
    }

    /**
     * @throws \Exception
     */
    public function handle($data, $order): array
    {
        foreach ($this->strategies as $strategy) {
            if ($strategy->canProcess($data)) {
                return $strategy->process($data, $order);
            }
        }

        $this->throwUnprocessableStrategyException($data);
    }

    /**
     * @throws \Exception
     */
    private function throwUnprocessableStrategyException(ShippingProvider $data): void
    {
        throw new \Exception(
            "Can not process strategy with shipping provider key: " . $data->getShippingProviderKey()
        );
    }
}