<?php

declare(strict_types=1);

namespace App\Service\Validator;

use Symfony\Component\Validator\Constraints\Collection;

interface ValidatorConstraintsInterface
{
    public function constraints(): Collection;
}
