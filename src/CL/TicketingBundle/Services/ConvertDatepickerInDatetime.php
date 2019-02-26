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


  public function convertDatepicker ($date)
  {
    // $date = '02/21/2019';
    // $locale = 'en';
    // dump($date);die;
    if ($this->locale == 'fr') {
      if (is_string($date))
      {
        $date = str_replace('/', '-', $date);

        $date = new \DateTime($date);;

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
