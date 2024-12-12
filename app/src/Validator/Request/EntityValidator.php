<?php

namespace App\Validator\Request;

use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class EntityValidator
{
    public function __construct(private ValidatorInterface $validator){}

    public function validate(object $entity): array
    {
        $errors = $this->validator->validate($entity);
        return self::mapErrorsToArray($errors);
    }

    private static function mapErrorsToArray(ConstraintViolationListInterface $errors): array
    {
        $errorMessages = [];
        foreach ($errors as $error) {
            $errorMessages[$error->getPropertyPath()][] = $error->getMessage();
        }
        return $errorMessages;
    }
}