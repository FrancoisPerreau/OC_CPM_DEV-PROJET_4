<?php
// src/CL/TicketingBundle/Validator/NoPastHourValidator.php

namespace CL\TicketingBundle\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

use CL\TicketingBundle\Services\ConvertDatepickerInDatetime;



class NoPastHourValidator extends ConstraintValidator
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

    $choiceDate = $this->serviceConvertDatePicker
                       ->convertDatepicker($choiceDate);
    $now = new \DateTime('now');

    if ($now->format('d') == $choiceDate->format('d') &&
        $now->format('m') == $choiceDate->format('m') &&
        $now->format('Y') == $choiceDate->format('Y') &&
        $now->format('H') > $this->ticketingGeneral['past_day_hour']
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
