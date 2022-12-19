<?php

namespace App\Service\Validator;

use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Service\Validator\ValidatorInterface as ValidatorServiceInterface;
use JMS\Serializer\ArrayTransformerInterface;
use Symfony\Component\Validator\Exception\ConstraintDefinitionException;

class Validator implements ValidatorServiceInterface
{
    public function __construct(
        protected ValidatorInterface $validator,
        protected ArrayTransformerInterface $arrayTransformer,
    ) {
    }

    public function validate(
        $data,
        ValidatorConstraintsInterface $validatorConstraints,
    ): void {
        $errors = $this->validator->validate(
            $this->arrayTransformer->toArray($data),
            $validatorConstraints->constraints(),
        );

        if (count($errors) !== 0) {
            try {
                throw new ConstraintDefinitionException($errors[0]->getMessage());
            } catch (\Exception $e) {
                echo $e->getMessage();
                exit();
            }
        }
    }

}