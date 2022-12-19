<?php

namespace App\Command;

use App\Model\MockOrder;
use App\Model\ShippingProvider;
use App\Model\ShippingProviderConstraints;
use App\Model\ShippingProviderContext;
use JMS\Serializer\ArrayTransformerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class RegisterShippingCommand extends Command
{
    protected static $defaultName = 'app:register-shipment';

    public function __construct(
        private readonly ShippingProviderContext $shippingProviderContext,
        private readonly MockOrder $order,
        private readonly ValidatorInterface $validator,
        private readonly ShippingProviderConstraints $shippingProviderConstraints,
        private readonly ArrayTransformerInterface $arrayTransformer,
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

        $errors = $this->validator->validate(
            $this->arrayTransformer->toArray($data),
            $this->shippingProviderConstraints->constraints(),
        );

        if ($errors->count()) {
            $this->getErrorMessageOutput($errors, $output);

            return 0;
        }

        $registeredShippingProvider = $this->shippingProviderContext->handle($data, $order);

        $this->getShippingRegisterMessageOutput($shippingProviderKey, $registeredShippingProvider, $output);

        return 0;
    }

    private function getErrorMessageOutput(ConstraintViolationList $errors, OutputInterface $output): void
    {
        $output->write("", true);
        $output->write("<fg=red>   {$errors[0]->getMessage()}</>", true);
        $output->write("", true);
    }

    private function getShippingRegisterMessageOutput(
        $shippingProviderKey,
        $registeredShippingProvider,
        OutputInterface $output
    ): void {
        $output->write("", true);
        $output->write("<fg=green>   $shippingProviderKey</>", true);
        $output->write("<fg=green>   {$registeredShippingProvider['message']}</>", true);
        $output->write("<fg=red>   {$registeredShippingProvider['content']}</>", true);
        $output->write("", true);
    }
}