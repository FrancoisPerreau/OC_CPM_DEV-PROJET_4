<?php
// src/CL/TicketingBundle/Services/GenerateCode/GenerateCodeWithDate.php

namespace CL\TicketingBundle\Services\GenerateCode;

class GenerateCodeWithDate
{

  public function createCode (\DateTime $date)
  {
    $dateToString = $date->format('Ymd-His');
    $random = bin2hex(random_bytes(8));

    return $dateToString . '-' . $random;
  }
}
