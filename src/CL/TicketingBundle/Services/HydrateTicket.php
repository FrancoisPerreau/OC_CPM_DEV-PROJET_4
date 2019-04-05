<?php
// src/CL/TicketingBundle/Services/Ticket/HydrateTicket.php

namespace CL\TicketingBundle\Services;

use Symfony\Component\HttpFoundation\Session\Session;
use CL\TicketingBundle\Entity\Ticket;

class HydrateTicket
{
  private $serviceGenerateCode;
  private $serviceDefinePriceByBirthday;
  private $serviceConvertDatePicker;
  private $ticketPrices;

  public function __construct(
    GenerateCodeWithDate $serviceGenerateCode,
    PriceByBirthday $serviceDefinePriceByBirthday,
    ConvertDatepickerInDatetime $serviceConvertDatePicker,
    $ticketPrices
    )
  {
    $this->serviceGenerateCode = $serviceGenerateCode;
    $this->serviceDefinePriceByBirthday = $serviceDefinePriceByBirthday;
    $this->serviceConvertDatePicker = $serviceConvertDatePicker;
    $this->ticketPrices = $ticketPrices;
  }

  /**
   * Hydrate Ticket
   * @param  Ticket $ticket
   * @param  $visitDate
   * @param  $visitType
   */
  public function hydrate(Ticket $ticket, $visitDate, $visitType)
  {
    $date = $this->serviceConvertDatePicker->convertDatepicker($visitDate);

    $ticketCode = $this->serviceGenerateCode->createTicketCode($date);
    $reducedPrice = $ticket->getReducedPrice();
    $birthday = $ticket->getBirthday();


    $ticket->setCode($ticketCode);

    if ($visitType == 0) // Ticket for day
    {
      if ($reducedPrice == true)
      {
        $ticket->setPrice($this->ticketPrices['reduced_price_day']);
      }
      else {
        $ticket->setPrice($this
          ->serviceDefinePriceByBirthday
          ->defineDayPrice($birthday));
      }
    }
    elseif ($visitType == 1) // Ticket for half day
    {
      if ($reducedPrice == true)
      {
        $ticket->setPrice($this->ticketPrices['reduced_price_half']);
      }
      else {
        $ticket->setPrice($this
          ->serviceDefinePriceByBirthday
          ->defineHalfDayPrice($birthday));
      }
    }
  }

}
