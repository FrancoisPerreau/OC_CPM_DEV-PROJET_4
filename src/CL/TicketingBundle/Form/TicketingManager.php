<?php
// src/CL/TicketingBundle/Services/TicketingManager.php

namespace CL\TicketingBundle\Services;

use Doctrine\ORM\EntityManager;
use Doctrine\Common\Collections\ArrayCollection;

class TicketingManager
{
  protected $em;

  // CONSTRUCTEUR
  // =======================
  public function __construct(EntityManager $em)
  {
    $this->em = $em;
  }

  // =======================
  // MÉTHODES ==============
  // =======================

  // EntityManager --------------
  public function save($entity)
  {
    // dump($entity);die;
    return $this
      ->myPersist($entity)
      ->myFlush();
  }


  public function myPersist($entity)
  {
    $this->em->persist($entity);

    return $this;
  }

  public function myFlush()
  {
    $this->em->flush();

    return $this;
  }

}
