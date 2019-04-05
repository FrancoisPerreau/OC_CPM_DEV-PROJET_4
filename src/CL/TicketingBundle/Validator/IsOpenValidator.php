<?php
// src/CL/TicketingBundle/Validator/DaysClosedValidator.php

namespace CL\TicketingBundle\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

use CL\TicketingBundle\Services\ConvertDatepickerInDatetime;
use CL\TicketingBundle\Services\DefineAscension;
use CL\TicketingBundle\Services\DefinePaques;
use CL\TicketingBundle\Services\DefinePentecote;


class IsOpenValidator extends ConstraintValidator
{
  private $serviceConvertDatePicker;
  private $serviceDefinePaques;
  private $serviceAscension;
  private $servicePentecote;
  private $closedDays;
  private $closedHoliday;


  public function __construct(
    ConvertDatepickerInDatetime $serviceConvertDatePicker,
    DefinePaques $serviceDefinePaques,
    DefineAscension $serviceAscension,
    DefinePentecote $servicePentecote,
    $closedDays,
    $closedHoliday
    )
  {
     $this->serviceConvertDatePicker = $serviceConvertDatePicker;
     $this->serviceDefinePaques = $serviceDefinePaques;
     $this->serviceAscension = $serviceAscension;
     $this->servicePentecote = $servicePentecote;
     $this->closedDays = $closedDays;
     $this->closedHoliday = $closedHoliday;
   }


  /**
   * @param  $value
   * @param  Constraint $constraint
   */
  public function validate($value, Constraint $constraint)
  {
    $choiceDate = $this->serviceConvertDatePicker
                       ->convertDatepicker($value);

    $choiceDay = $choiceDate->format('d');
    $choiceMonth = $choiceDate->format('m');
    $choiceYear = $choiceDate->format('Y');
    $choiceWeekDay = $choiceDate->format('w');

    $today = new \Datetime('today');
    $thisYear = $today->format('Y');

    $sundayPaques = $this->serviceDefinePaques->paquesByYear($choiceYear);
    $mondayPaques = $this->serviceDefinePaques->defineMondayPaques($choiceYear);
    $mondayPaquesdDay = $mondayPaques->format('d');
    $mondayPaquesMonth = $mondayPaques->format('m');


    $sundayPaques = $this->serviceDefinePaques->paquesByYear($choiceYear);
    $ascension = $this->serviceAscension->defineThursdayAscensionByPaques($sundayPaques);
    $ascensiondDay = $ascension->format('d');
    $ascensionMonth = $ascension->format('m');


    $sundayPaques = $this->serviceDefinePaques->paquesByYear($choiceYear);
    $pentecote = $this->servicePentecote->definePentecoteByPaques($sundayPaques);
    $pentecoteDay = $pentecote->format('d');
    $pentecoteMonth = $pentecote->format('m');


    if ($choiceWeekDay == 0 || $choiceWeekDay == 2)
    {
      $this->context->addViolation($constraint->message);
    }



    foreach ($this->closedDays as $dayClosed)
    {
      $dateClosed = new \Datetime($thisYear.'-'.$dayClosed);
      $dayClosedDay = $dateClosed->format('d');
      $dayClosedMonth = $dateClosed->format('m');


      if ($choiceDay == $dayClosedDay && $choiceMonth == $dayClosedMonth )
      {
        $this->context->addViolation($constraint->message);
      }
    }


    if ($this->closedHoliday['paques_closed'] === true && $choiceDay == $mondayPaquesdDay && $choiceMonth == $mondayPaquesMonth ||
        $this->closedHoliday['ascension_closed'] === true && $choiceDay == $ascensiondDay && $choiceMonth == $ascensionMonth ||
        $this->closedHoliday['pentecote_closed'] === true && $choiceDay == $pentecoteDay && $choiceMonth == $pentecoteMonth)
    {
      $this->context->addViolation($constraint->message);
    }
  }

}
