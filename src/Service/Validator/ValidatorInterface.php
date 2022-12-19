<?php

declare(strict_types=1);

namespace App\Service\Validator;

interface ValidatorInterface
{
    public function validate(
        object $data,
        ValidatorConstraintsInterface $validatorConstraints,
    );
}
