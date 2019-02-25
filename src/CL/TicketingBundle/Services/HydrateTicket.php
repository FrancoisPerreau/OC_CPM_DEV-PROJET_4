<?php
// src/CL/TicketingBundle/Services/Ticket/HydrateTicket.php

namespace CL\TicketingBundle\Services;

use Symfony\Component\HttpFoundation\Session\Session;
use CL\TicketingBundle\Entity\Ticket;
use CL\TicketingBundle\TicketingConstants\TicketPrices;

class HydrateTicket
{
  private $session;
  private $serviceGenerateCode;
  private $servicedefinePriceByBirthday;
  private $serviceConvertDatePicker;

  public function __construct(
    Session $session,
    GenerateCodeWithDate $serviceGenerateCode,
    PriceByBirthday $servicedefinePriceByBirthday,
    ConvertDatepickerInDatetime $serviceConvertDatePicker
    )
  {
    $this->session = $session;
    $this->serviceGenerateCode = $serviceGenerateCode;
    $this->servicedefinePriceByBirthday = $servicedefinePriceByBirthday;
    $this->serviceConvertDatePicker = $serviceConvertDatePicker;
  }

  public function hydrate(Ticket $ticket)
  {
    $purchase = $this->session->get('Purchase');    
    $date = $purchase->getVisitDate();
    $date = $this->serviceConvertDatePicker->convertDatepicker($date);

    $ticketCode = $this->serviceGenerateCode
                       ->createTicketCode($date);
    $visitType = $purchase->getVisitType();
    $reducedPrice = $ticket->getReducedPrice();
    $birthday = $ticket->getBirthday();


    $ticket->setCode($ticketCode);

    if ($visitType == 0) // Ticket for day
    {
      if ($reducedPrice == true)
      {
        $ticket->setPrice(TicketPrices::REDUCED_PRICE_DAY);
      }
      else {
        $ticket->setPrice($this
          ->servicedefinePriceByBirthday
          ->defineDayPrice($birthday));
      }
    }
    elseif ($visitType == 1) // Ticket for half day
    {
      if ($reducedPrice == true)
      {
        $ticket->setPrice(TicketPrices::REDUCED_PRICE_HALF);
      }
      else {
        $ticket->setPrice($this
          ->servicedefinePriceByBirthday
          ->defineHalfDayPrice($birthday));
      }
    }
  }

}
