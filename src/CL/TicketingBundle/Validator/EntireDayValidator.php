<?php
// src/CL/TicketingBundle/Validator/EntireDayValidator.php

namespace CL\TicketingBundle\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

use CL\TicketingBundle\TicketingConstants\DayClosedAndHourLimit;


class EntireDayValidator extends ConstraintValidator
{
  /**
   * @param  $value
   * @param  Constraint $constraint
   */
  public function validate($entireDay, Constraint $constraint)
  {
    // dump($entireDay);die;
    // $value = '19/02/2019';
    $choiceDate = date_create_from_format('d/m/Y', $entireDay);

    $now = new \DateTime('now');

    if ($now->format('d') == $choiceDate->format('d') &&
        $now->format('m') == $choiceDate->format('m') &&
        $now->format('Y') == $choiceDate->format('Y') &&
        $now->format('H') > DayClosedAndHourLimit::HALF_DAY_HOUR
        )
    {
      $this->context->addViolation($constraint->message);
    }
    // die;
    //
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
