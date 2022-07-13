<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class ConstraintMenuValidator extends ConstraintValidator{

    public function validate(mixed $value, Constraint $constraint)
    {
        if()
        dd($value);
    }

}