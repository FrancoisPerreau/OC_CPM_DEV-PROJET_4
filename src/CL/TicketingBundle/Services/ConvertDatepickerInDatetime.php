<?php
// src/CL/TicketingBundle/Services/GenerateCode/GenerateCodeWithDate.php

namespace CL\TicketingBundle\Services;

use Doctrine\ORM\EntityManager;


use CL\TicketingBundle\Entity\Purchase;
use CL\TicketingBundle\Entity\Ticket;

class ConvertDatepickerInDatetime
{
  private $locale;

  // CONSTRUCTEUR
  // =======================
  public function __construct($locale)
  {
    $this->locale = $locale;
  }

  /**
   * Convert string in DateTime according to the local
   * @param  $date
   * @return DateTime
   */
  public function convertDatepicker ($date)
  {
    if ($this->locale == 'fr') {
      if (is_string($date))
      {
        $date = str_replace('/', '-', $date);

        $date = new \DateTime($date);
      }
    }

    if ($this->locale == 'en')
    {
      if (is_string($date))
      {
        $dateExplode = explode('/', $date);

        $d = $dateExplode[1];
        $m = $dateExplode[0];
        $y = $dateExplode[2];

        $date = new \DateTime($d.'-'.$m.'-'.$y);
      }
    }

    return $date;
  }

}
