<?php
// src/CL/TicketingBundle/Validator/NoPastHourValidator.php

namespace CL\TicketingBundle\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

use CL\TicketingBundle\Services\ConvertDatepickerInDatetime;
use CL\TicketingBundle\TicketingConstants\DayClosedAndHourLimit;



class NoPastHourValidator extends ConstraintValidator
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
    $choiceDate = $value->getVisitDate();

    $choiceDate = $this->serviceConvertDatePicker
                       ->convertDatepicker($choiceDate);
    $now = new \DateTime('now');

    if ($now->format('d') == $choiceDate->format('d') &&
        $now->format('m') == $choiceDate->format('m') &&
        $now->format('Y') == $choiceDate->format('Y') &&
        $now->format('H') > DayClosedAndHourLimit::PAST_DAY_HOUR
        )
    {
      // $this->context->addViolation($constraint->message);
      $this->context->buildViolation($constraint->message)
                    ->atPath('visitDate')
                    ->addViolation()
                    ;
    }
  }

}
