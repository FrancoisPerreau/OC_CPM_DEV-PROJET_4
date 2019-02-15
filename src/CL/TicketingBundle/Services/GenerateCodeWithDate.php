<?php
// src/CL/TicketingBundle/Services/GenerateCode/GenerateCodeWithDate.php

namespace CL\TicketingBundle\Services;

class GenerateCodeWithDate
{

  public function createPurchaseCode (\DateTime $date)
  {
    $dateToString = $date->format('Ymd-His');
    $random = bin2hex(random_bytes(8));

    return $dateToString . '-' . $random;
  }


  public function createTicketCode (\DateTime $date)
  {
    $dateToString = $date->format('Ymd');
    $random = bin2hex(random_bytes(8));

    return $dateToString . '-' . $random;
  }
}
