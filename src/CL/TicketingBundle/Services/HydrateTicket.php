<?php
// src/CL/TicketingBundle/Services/Ticket/HydrateTicket.php

namespace CL\TicketingBundle\Services;

use Symfony\Component\HttpFoundation\Session\Session;
use CL\TicketingBundle\Entity\Ticket;
use CL\TicketingBundle\TicketingConstants\TicketPrices;

class HydrateTicket
{
  private $serviceGenerateCode;
  private $serviceDefinePriceByBirthday;
  private $serviceConvertDatePicker;

  public function __construct(
    GenerateCodeWithDate $serviceGenerateCode,
    PriceByBirthday $serviceDefinePriceByBirthday,
    ConvertDatepickerInDatetime $serviceConvertDatePicker
    )
  {
    $this->serviceGenerateCode = $serviceGenerateCode;
    $this->serviceDefinePriceByBirthday = $serviceDefinePriceByBirthday;
    $this->serviceConvertDatePicker = $serviceConvertDatePicker;
  }

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
        $ticket->setPrice(TicketPrices::REDUCED_PRICE_DAY);
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
        $ticket->setPrice(TicketPrices::REDUCED_PRICE_HALF);
      }
      else {
        $ticket->setPrice($this
          ->serviceDefinePriceByBirthday
          ->defineHalfDayPrice($birthday));
      }
    }
  }

}
