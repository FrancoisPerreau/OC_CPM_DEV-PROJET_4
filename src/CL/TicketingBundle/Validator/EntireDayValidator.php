<?php
// src/CL/TicketingBundle/Validator/EntireDayValidator.php

namespace CL\TicketingBundle\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

use CL\TicketingBundle\Services\ConvertDatepickerInDatetime;


class EntireDayValidator extends ConstraintValidator
{
  private $serviceConvertDatePicker;
  private $ticketingGeneral;

  public function __construct(ConvertDatepickerInDatetime $serviceConvertDatePicker, $ticketingGeneral)
  {
     $this->serviceConvertDatePicker = $serviceConvertDatePicker;
     $this->ticketingGeneral = $ticketingGeneral;
   }


  /**
   * @param  $value
   * @param  Constraint $constraint
   */
  public function validate($value, Constraint $constraint)
  {

    $choiceDate = $value->getVisitDate();
    $visitType = $value->getVisitType();
    // $choiceDate = '26/02/2019';
    $choiceDate = $this->serviceConvertDatePicker
                       ->convertDatepicker($choiceDate);
    $now = new \DateTime('now');


    if ($now->format('d') == $choiceDate->format('d') &&
        $now->format('m') == $choiceDate->format('m') &&
        $now->format('Y') == $choiceDate->format('Y') &&
        $visitType == 0 &&
        $now->format('H') > $this->ticketingGeneral['half_day_hour'] - 1
        )
    {
      // $this->context->addViolation($constraint->message);
      $this->context->buildViolation($constraint->message)
                    ->atPath('visitType')
                    ->addViolation()
                    ;
    }
  }

}
