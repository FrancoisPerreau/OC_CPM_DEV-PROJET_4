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

  public function __construct(
    Session $session,
    GenerateCodeWithDate $serviceGenerateCode,
    PriceByBirthday $servicedefinePriceByBirthday
    )
  {
    $this->session = $session;
    $this->serviceGenerateCode = $serviceGenerateCode;
    $this->servicedefinePriceByBirthday = $servicedefinePriceByBirthday;
  }

  public function hydrate(Ticket $ticket)
  {
    // $session = new Session;
    $data = $this->session->get('TicketDateChoiceFomData');
    $date = strtotime($data['ticketDate']);
    $date = date('Y/m/d');
    $ticketCode = $this
      ->serviceGenerateCode
      ->createTicketCode(new \DateTime($date));
    $ticketType = $data['ticketDayType'];
    $reducedPrice = $ticket->getReducedPrice();
    $birthday = $ticket->getBirthday();


    $ticket->setVisitDate(new \DateTime($date));
    $ticket->setType($data['ticketDayType']);
    $ticket->setCode($ticketCode);

    if ($ticketType == 0) // Ticket for day
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
    elseif ($ticketType == 1) // Ticket for half day
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
