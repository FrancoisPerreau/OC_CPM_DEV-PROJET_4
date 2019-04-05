<?php
// src/CL/TicketingBundle/Validator/DaysClosedValidator.php

namespace CL\TicketingBundle\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

use Doctrine\ORM\EntityManager;

use CL\TicketingBundle\Entity\Purchase;
use CL\TicketingBundle\Services\ConvertDatepickerInDatetime;


class NoMoreValidator extends ConstraintValidator
{
  protected $em;
  private $serviceConvertDatePicker;
  private $ticketingGeneral;

   public function __construct(
     EntityManager $em,
     ConvertDatepickerInDatetime $serviceConvertDatePicker,
     $ticketingGeneral
     )
   {
      $this->em = $em;
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

    $choiceDate = $this->serviceConvertDatePicker->convertDatepicker($choiceDate);

    $ticketsOnThisDate = $this
      ->em
      ->getRepository(Purchase::class)
      ->findNbTicketsOnDate($choiceDate);

    $purchaseTickets = $value->getTicketNb();

    $totalTickets = (int)$ticketsOnThisDate + $purchaseTickets;


    if ($totalTickets > $this->ticketingGeneral['max_tickets_by_day'])
    {
      $this->context->buildViolation($constraint->message)
                    ->atPath('ticketNb')
                    ->addViolation();
    }
  }

}
