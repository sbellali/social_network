<?php
namespace App\Validator;

use Symfony\Component\Validator\Constraint;

#[\Attribute]
class IsAdult extends Constraint
{
    public $message = 'The age of majority is required.';
}
