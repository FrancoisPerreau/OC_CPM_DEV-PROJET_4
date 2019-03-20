<?php
// src/CL/TicketingBundle/Services/DefinePentecote.php

namespace CL\TicketingBundle\Services;

class DefinePentecote
{
  public function definePentecoteByPaques (\DateTime $paques)
  {
    return $paques->add(new \DateInterval('P50D'));
  }

}
