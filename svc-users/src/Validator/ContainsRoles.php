<?php
namespace App\Validator;

use Symfony\Component\Validator\Constraint;

#[\Attribute]
class ContainsRoles extends Constraint
{
    public $message = 'The roles [{{ roles }}] is illegal, please refere to the role\'s list.';
}
