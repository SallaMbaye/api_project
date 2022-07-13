<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use App\Entity\MenuFrite;
use App\Entity\MenuPortion;
use App\Entity\Menu;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\ConstraintValidator;

class ConstraintMenuValidator extends ConstraintValidator{

    public function validate($value, Constraint $constraint)
    {
        $tab[]=$value;
        //dd($tab);
    }

}