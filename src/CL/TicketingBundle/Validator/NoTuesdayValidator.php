<?php
// src/CL/TicketingBundle/Validator/DaysClosedValidator.php

namespace CL\TicketingBundle\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

use CL\TicketingBundle\Services\ConvertDatepickerInDatetime;


class NoTuesdayValidator extends ConstraintValidator
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
    // $value = "12/02/2019";
    $choiceDate = $this->serviceConvertDatePicker
                       ->convertDatepicker($value);

    $choiceWeekDay = $choiceDate->format('w');

    if ($choiceWeekDay == 2)
    {
      $this->context->addViolation($constraint->message);
    }
  }

}
