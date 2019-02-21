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
    dump($value);
    // $value = '19/02/2019';

    $choiceDate = $value->getVisitDate();
    $visitType = $value->getVisitType();
    dump($choiceDate);
    dump($visitType);

    $choiceDate = date_create_from_format('d/m/Y', $choiceDate);
    // dump($choiceDate);die;

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


    // if ($value == 0)
    // {
    //   $now = new \DateTime('now');
    //   $hoursPourchase = $now->format('H');
    //   dump($hoursPourchase);
    //   dump(DayClosedAndHourLimit::HALF_DAY_HOUR);
    //   die;
    //
    //   if ($hoursPourchase > DayClosedAndHourLimit::HALF_DAY_HOUR)
    //   {
    //     $this->context->addViolation($constraint->message);
    //   }
    // }
  }

}
