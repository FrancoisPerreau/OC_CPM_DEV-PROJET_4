<?php
// src/CL/TicketingBundle/Validator/DaysClosedValidator.php

namespace CL\TicketingBundle\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

use CL\TicketingBundle\TicketingConstants\DayClosedAndHourLimit;


class NoTuesdayValidator extends ConstraintValidator
{
  /**
   * @param  $value
   * @param  Constraint $constraint
   */
  public function validate($value, Constraint $constraint)
  {
    // $value = "12/02/2019";
    if (is_string($value)) {
      $value = date_create_from_format('d/m/Y', $value);
    }

    $choiceWeekDay = $value->format('w');

    if ($choiceWeekDay == 2)
    {
      $this->context->addViolation($constraint->message);
    }
  }

}
