<?php
// src/CL/TicketingBundle/Validator/DaysClosedValidator.php

namespace CL\TicketingBundle\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use CL\TicketingBundle\Services\ConvertDatepickerInDatetime;



class NoPastDaysValidator extends ConstraintValidator
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
    // $value = "22/02/2019";
    $choiceDate = $this->serviceConvertDatePicker
                       ->convertDatepicker($value);

    $today = new \DateTime(date('Y-m-d'));

    if ($today > $choiceDate)
    {
      $this->context->addViolation($constraint->message);
    }
  }

}
