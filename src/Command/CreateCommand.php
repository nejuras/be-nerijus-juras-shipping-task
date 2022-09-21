<?php

namespace App\Command;

use App\Model\MockOrder;
use App\Model\ShippingProvider;
use App\Model\ShippingProviderContext;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class CreateCommand extends Command
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
        $this->order = $order;
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
        $shippingProviderKey = $input->getOption('shippingProviderKey') ?: 'ups';

        $data = new ShippingProvider($shippingProviderKey);
        $registeredShippingProvider = $this->shippingProviderContext->handle($data, $this->order->createOrder());
        $shippingProvider = json_encode($registeredShippingProvider, JSON_PRETTY_PRINT);

        $output->write("<fg=green>   Shipment registered!</>", true);
        $output->write("", true);
        $output->write("<fg=green>   $shippingProvider</>", true);

        return 0;
    }
}