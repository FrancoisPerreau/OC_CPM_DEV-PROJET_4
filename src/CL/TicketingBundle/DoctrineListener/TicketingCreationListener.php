<?php
// src/CL/TicketingBundle/DoctrineListener/TicketingCreationListener.php
namespace CL\TicketingBundle\DoctrineListener;


use Doctrine\Common\Persistence\Event\LifecycleEventArgs;

use CL\TicketingBundle\Email\TicketingMailler;
use CL\TicketingBundle\Entity\Purchase;



class TicketingCreationListener
{
  private $ticketingMailler;

  function __construct(TicketingMailler $ticketingMailler)
  {
    $this->ticketingMailler = $ticketingMailler;
  }


  public function postPersist(LifecycleEventArgs $args)
  {
    $entity = $args->getObject();

    // On ne veut envoyer un email que pour les entités Purchase
    if (!$entity instanceof Purchase)
    {
      return;
    }

    $this->ticketingMailler->sendPurchaseNotification($entity);
  }

}
