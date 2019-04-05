<?php
// src/CL/TicketingBundle/Services/DefinePrices/PriceByBirthday.php

namespace CL\TicketingBundle\Services;

class PriceByBirthday
{
  /**
   * Define Price by age for entire day
   * @param  DateTime
   * @return $price
   */

   private $ageRanges;
   private $ticketPrices;

   // CONSTRUCTEUR
   // =======================
   public function __construct($ticketingAgeRanges, $ticketPrices)
   {
     $this->ageRanges = $ticketingAgeRanges;
     $this->ticketPrices = $ticketPrices;
   }


  public function defineDayPrice(\DateTime $date)
  {
    $today = new \DateTime('today');
    $diff = date_diff($today, $date)->y;

    switch ($diff)
    {
      case ($diff < $this->ageRanges['child_age_mini']):
        return 0;
        break;

      case ($this->ageRanges['child_age_mini'] - 1 < $diff && $diff < $this->ageRanges['child_age_maxi'] + 1):
        return $this->ticketPrices['child_price_day'];
        break;

        case ($diff > $this->ageRanges['senior_age_mini'] - 1):
          return $this->ticketPrices['senior_price_day'];
          break;

      default:
        return $this->ticketPrices['normal_price_day'];
        break;
    }
  }

  /**
   * Define Price by age for half day
   * @param  DateTime
   * @return $price
   */
  public function defineHalfDayPrice(\DateTime $date)
  {

    $today = new \DateTime('today');
    $diff = date_diff($today, $date)->y;

    switch ($diff)
    {
      case ($diff < $this->ageRanges['child_age_mini']):
        return 0;
        break;

      case ($this->ageRanges['child_age_mini'] - 1 < $diff && $diff < $this->ageRanges['child_age_maxi'] + 1):
        return $this->ticketPrices['child_price_half'];
        break;

        case ($diff > $this->ageRanges['senior_age_mini'] - 1):
          return $this->ticketPrices['senior_price_half'];
          break;

      default:
        return $this->ticketPrices['normal_price_half'];
        break;
    }
  }

}
