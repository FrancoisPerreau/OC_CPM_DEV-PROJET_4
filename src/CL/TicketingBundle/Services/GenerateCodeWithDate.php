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
    // $code = '20190221-181313-8a84ad8fcb8ea9ad';

    while ($this->em->getRepository(Purchase::class)->findOneByCode($code))
    {
      // echo('Je suis dans la base');
      $code = $this->generateCode($date);
    }

    // dump('C-' . $code);die;
    return 'C-' . $code;
  }


  public function createTicketCode (\DateTime $date)
  {
    $code = $this->generateCode($date);
    // $code = '20190221-181313-8a84ad8fcb8ea9ad';

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
