<?php
// src/CL/TicketingBundle/Validator/DaysClosedValidator.php

namespace CL\TicketingBundle\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

use CL\TicketingBundle\Services\ConvertDatepickerInDatetime;
use CL\TicketingBundle\TicketingConstants\DayClosedAndHourLimit;


class IsOpenValidator extends ConstraintValidator
{
  private $serviceConvertDatePicker;

  public function __construct(ConvertDatepickerInDatetime $serviceConvertDatePicker)
  {
     $this->serviceConvertDatePicker = $serviceConvertDatePicker;
   }


  /**
   * @param  $value
   * @param  Constraint $constraint
   */
  public function validate($value, Constraint $constraint)
  {
    // $value = "25/12/2021";
    $choiceDate = $this->serviceConvertDatePicker
                       ->convertDatepicker($value);

    $choiceDay = $choiceDate->format('d');
    $choiceMonth = $choiceDate->format('m');

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
