<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class ConstraintMenuValidator extends ConstraintValidator{

    public function validate(mixed $value, Constraint $constraint)
    {
        dd($value->getMenutailles());
        //if($value->getMenuTaille())
        dd($value);
    }

}