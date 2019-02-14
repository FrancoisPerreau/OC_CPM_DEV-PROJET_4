<?php
// src/CL/TicketingBundle/Services/DefinePrices/PriceByBirthday.php

namespace CL\TicketingBundle\Services\DefinePrices;

use CL\TicketingBundle\TicketingConstants\TicketPrices;

class PriceByBirthday
{
  // PRIX POUR LA JOURNÉÉ
  // =============================
  public function defineDayPrice(\DateTime $date)
  {
    $today = new \DateTime('today');

    $diff = date_diff($today, $date)->y;

    switch ($diff)
    {
      case ($diff < 4):
        return 0;
        break;

      case (3 < $diff && $diff < 13):
        return TicketPrices::CHILD_PRICE_DAY;
        break;

        case ($diff > 59):
          return TicketPrices::SENIOR_PRICE_DAY;
          break;

      default:
        return TicketPrices::NORMAL_PRICE_DAY;
        break;
    }
  }

  // PRIX POUR LA DEMI-JOURNÉÉ
  // =============================
  public function defineHalfDayPrice(\DateTime $date)
  {
    $today = new \DateTime('today');

    $diff = date_diff($today, $date)->y;

    switch ($diff)
    {
      case ($diff < 4):
        return 0;
        break;

      case (3 < $diff && $diff < 13):
        return TicketPrices::CHILD_PRICE_HALF;
        break;

        case ($diff > 59):
          return TicketPrices::SENIOR_PRICE_HALF;
          break;

      default:
        return TicketPrices::NORMAL_PRICE_HALF;
        break;
    }
  }

}
