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

    private $shippingProviderContext;
    private $order;

    public function __construct(
        ShippingProviderContext $shippingProviderContext,
        MockOrder $order
    ) {
        parent::__construct();

        $this->shippingProviderContext = $shippingProviderContext;
        $this->order = $order->createOrder();
    }

    protected function configure(): void
    {
        $this->addOption('shippingProviderKey', null, InputOption::VALUE_REQUIRED);
    }

    /**
     * @throws \Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $shippingProviderKey = $input->getOption('shippingProviderKey') ?: $this->order->getShippingProviderKey();

        $data = new ShippingProvider($shippingProviderKey);
        $registeredShippingProvider = $this->shippingProviderContext->handle($data, $this->order);
//        $shippingProvider = json_encode($registeredShippingProvider, JSON_PRETTY_PRINT);
//dump($registeredShippingProvider);
        $output->write("<fg=green>   {$registeredShippingProvider['message']}</>", true);
        $output->write("", true);
        $output->write("<fg=green>   {$registeredShippingProvider['content']}</>", true);

        return 0;
    }
}