<?php

namespace App\Exception;

class EntityValidationException extends \Exception
{
    public function __construct(array $errors)
    {
        parent::__construct(json_encode($errors));
    }
}