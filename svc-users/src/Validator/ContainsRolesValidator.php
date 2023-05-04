<?php
namespace App\Validator;

use App\Enum\RoleEnum;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

class ContainsRolesValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint): void
    {
        if (!$constraint instanceof ContainsRoles) {
            throw new UnexpectedTypeException($constraint, ContainsRoles::class);
        }

        if (null === $value || '' === $value) {
            return;
        }

        if (! is_array($value)) {
            throw new UnexpectedValueException($value, 'array');
        }

        $illegalRolles = $this->getIllegalRoles($value);

        if (!empty($illegalRolles)) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ roles }}', implode(", ", $illegalRolles))
                ->addViolation();
        }
    }

    private function getIllegalRoles(array $roles): array
    {
        return array_diff($roles, array_column(RoleEnum::cases(), 'value'));
    }
}
