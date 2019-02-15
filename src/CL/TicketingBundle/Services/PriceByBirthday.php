<?php
// src/CL/TicketingBundle/Services/DefinePrices/PriceByBirthday.php

namespace CL\TicketingBundle\Services;

use CL\TicketingBundle\TicketingConstants\TicketPrices;
use CL\TicketingBundle\TicketingConstants\AgeRanges;

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
      case ($diff < AgeRanges::CHILD_AGE_MINI):
        return 0;
        break;

      case (AgeRanges::CHILD_AGE_MINI - 1 < $diff && $diff < AgeRanges::CHILD_AGE_MAXI + 1):
        return TicketPrices::CHILD_PRICE_DAY;
        break;

        case ($diff > AgeRanges::SENIOR_AGE_MINI - 1):
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
      case ($diff < AgeRanges::CHILD_AGE_MINI):
        return 0;
        break;

      case (AgeRanges::CHILD_AGE_MINI - 1 < $diff && $diff < AgeRanges::CHILD_AGE_MAXI + 1):
        return TicketPrices::CHILD_PRICE_HALF;
        break;

        case ($diff > AgeRanges::SENIOR_AGE_MINI - 1):
          return TicketPrices::SENIOR_PRICE_HALF;
          break;

      default:
        return TicketPrices::NORMAL_PRICE_HALF;
        break;
    }
  }

}
