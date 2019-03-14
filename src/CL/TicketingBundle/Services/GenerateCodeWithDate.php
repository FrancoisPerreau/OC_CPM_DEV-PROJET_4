<?php
// src/CL/TicketingBundle/Services/GenerateCode/GenerateCodeWithDate.php

namespace CL\TicketingBundle\Services;

use Doctrine\ORM\EntityManager;


use CL\TicketingBundle\Entity\Purchase;
use CL\TicketingBundle\Entity\Ticket;

class GenerateCodeWithDate
{
  protected $em;

  // CONSTRUCTEUR
  // =======================
  public function __construct(EntityManager $em)
  {
    $this->em = $em;
  }


  public function createPurchaseCode (\DateTime $date)
  {
    $code = $this->generateCode($date);

    // Pour être sur d'avoir un code unique
    while ($this->em->getRepository(Purchase::class)->findOneByCode($code))
    {
      $code = $this->generateCode($date);
    }

    return 'C-' . $code;
  }


  public function createTicketCode (\DateTime $date)
  {
    $code = $this->generateCode($date);

    // Pour être sur d'avoir un code unique
    while ($this->em->getRepository(Ticket::class)->findOneByCode($code))
    {
      $code = $this->generateCode($date);
    }

    return 'T-' . $code;
  }



  public function generateCode(\DateTime $date)
  {
    $dateToString = $date->format('Ymd');
    $random = bin2hex(random_bytes(4));

    return $dateToString . '-' . strtoupper($random);
  }
}
