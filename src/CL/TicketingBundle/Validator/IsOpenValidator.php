<?php
// src/CL/TicketingBundle/Validator/DaysClosedValidator.php

namespace CL\TicketingBundle\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

use CL\TicketingBundle\TicketingConstants\DayClosedAndHourLimit;


class IsOpenValidator extends ConstraintValidator
{
  /**
   * @param  $value
   * @param  Constraint $constraint
   */
  public function validate($value, Constraint $constraint)
  {
    // $value = "25/12/2019";
    if (is_string($value)) {
      $value = date_create_from_format('d/m/Y', $value);
    }

    // $value = date_create_from_format('d/m/Y', $value);
    $choiceDay = $value->format('d');
    $choiceMonth = $value->format('m');

    $today = new \Datetime('today');
    $thisYear = $today->format('Y');

    foreach (DayClosedAndHourLimit::DAYS_CLOSED as $dayClosed)
    {
      $dateClosed = new \Datetime($thisYear.'-'.$dayClosed);
      $dayClosedDay = $dateClosed->format('d');
      $dayClosedMonth = $dateClosed->format('m');

      if ($choiceDay == $dayClosedDay && $choiceMonth == $dayClosedMonth)
      {
        $this->context->addViolation($constraint->message);
      }
    }
  }

}
