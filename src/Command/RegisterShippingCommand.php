<?php

namespace App\Command;

use App\Model\MockOrder;
use App\Model\ShippingProvider;
use App\Model\ShippingProviderContext;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class RegisterShippingCommand extends Command
{
    protected static $defaultName = 'app:register-shipment';

    public function __construct(
        private readonly ShippingProviderContext $shippingProviderContext,
        private readonly MockOrder $order,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addOption('shippingProviderKey', null, InputOption::VALUE_REQUIRED);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $order = $this->order->createOrder();
        $shippingProviderKey = $input->getOption('shippingProviderKey') ?: $order->getShippingProviderKey();

        $data = new ShippingProvider($shippingProviderKey);
        $registeredShippingProvider = $this->shippingProviderContext->handle($data, $order);

        $output->write("", true);
        $output->write("<fg=green>   $shippingProviderKey</>", true);
        $output->write("<fg=green>   {$registeredShippingProvider['message']}</>", true);
        $output->write("<fg=red>   {$registeredShippingProvider['content']}</>", true);
        $output->write("", true);

        return 0;
    }
}