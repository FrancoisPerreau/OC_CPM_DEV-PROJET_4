<?php
// src/CL/TicketingBundle/Validator/DaysClosedValidator.php

namespace CL\TicketingBundle\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;


class NoPastDaysValidator extends ConstraintValidator
{
  /**
   * @param  $value
   * @param  Constraint $constraint
   */
  public function validate($value, Constraint $constraint)
  {
    // $value = "22/02/2019";

    $value = date_create_from_format('d/m/Y', $value);
    $today = new \DateTime(date('Y-m-d'));

    if ($today > $value)
    {
      $this->context->addViolation($constraint->message);
    }
  }

}
