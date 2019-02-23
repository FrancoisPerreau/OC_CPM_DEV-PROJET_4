<?php
// src/CL/TicketingBundle/Validator/EntireDayValidator.php

namespace CL\TicketingBundle\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\HttpFoundation\Session\Session;

use CL\TicketingBundle\TicketingConstants\DayClosedAndHourLimit;


class EntireDayValidator extends ConstraintValidator
{
  /**
   * @param  $value
   * @param  Constraint $constraint
   */
  public function validate($value, Constraint $constraint)
  {

    $choiceDate = $value->getVisitDate();
    $visitType = $value->getVisitType();

    if (is_string($choiceDate)) {
      $choiceDate = date_create_from_format('d/m/Y', $choiceDate);
    }

    $now = new \DateTime('now');

    if ($now->format('d') == $choiceDate->format('d') &&
        $now->format('m') == $choiceDate->format('m') &&
        $now->format('Y') == $choiceDate->format('Y') &&
        $visitType == 0 &&
        $now->format('H') > DayClosedAndHourLimit::HALF_DAY_HOUR
        )
    {
      // $this->context->addViolation($constraint->message);
      $this->context->buildViolation($constraint->message)
                ->atPath('visitType')
                ->addViolation();
    }
  }

}
