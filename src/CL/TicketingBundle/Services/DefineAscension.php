<?php
// src/CL/TicketingBundle/Services/DefineAscension.php

namespace CL\TicketingBundle\Services;

class DefineAscension
{
  public function defineThursdayAscensionByPaques (\DateTime $paques)
  {
    return $paques->add(new \DateInterval('P39D'));
  }

}
