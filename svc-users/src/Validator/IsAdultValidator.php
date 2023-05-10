<?php
namespace App\Validator;

use DateTime;
use phpDocumentor\Reflection\Types\Boolean;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

class IsAdultValidator extends ConstraintValidator
{
    const AGE_MAJORITY = 18;
    public function validate($value, Constraint $constraint): void
    {
        if (!$constraint instanceof IsAdult) {
            throw new UnexpectedTypeException($constraint, IsAdult::class);
        }

        if (null === $value || '' === $value) {
            return;
        }

        if (!$value instanceof DateTime) {
            throw new UnexpectedValueException($value, DateTime::class);
        }

        if (!$this->isAdult($value)) {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }

    private function isAdult(DateTime $value): bool
    {
        $now = new DateTime();
        $interval = $now->diff($value);
        return $interval->y >= self::AGE_MAJORITY;
    }
}
