<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use App\Entity\MenuFrite;
use App\Entity\MenuPortion;
use Symfony\Component\Validator\ConstraintValidator;

class ConstraintMenuValidator extends ConstraintValidator{

    public function validate(mixed $value, Constraint $constraint)
    {
        dd($value[0]);
        dd($value);
    }

}