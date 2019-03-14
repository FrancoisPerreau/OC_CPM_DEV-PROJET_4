<?php
// src/CL/TicketingBundle/Services/AddedPrices.php

namespace CL\TicketingBundle\Services;

class AddedPrices
{

  /**
   * Add tickets prices
   * @param  Ticket $tickets
   * @return $totalPrice
   */
  public function totalPrice($tickets)
  {
    $totalPrice = 0;

    foreach ($tickets as $ticket)
    {
      $totalPrice = $totalPrice + $ticket->getPrice();
    }

    return $totalPrice;
  }

}
