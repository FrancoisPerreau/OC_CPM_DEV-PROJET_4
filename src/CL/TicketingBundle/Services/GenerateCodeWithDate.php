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

  /**
   * Create a purchase code
   * @param  DateTime $date
   * @return $code
   */
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

  /**
   * Create a ticket code
   * @param  DateTime $date
   * @return $code
   */
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


  /**
   * Generate a string according to the date
   * @param  DateTime $date
   * @return string
   */
  public function generateCode(\DateTime $date)
  {
    $dateToString = $date->format('Ymd');
    $random = bin2hex(random_bytes(4));

    return $dateToString . '-' . strtoupper($random);
  }
}
