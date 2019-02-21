<?php
// src/CL/TicketingBundle/Services/Ticket/hydratePurchase.php

namespace CL\TicketingBundle\Services;
use Symfony\Component\HttpFoundation\Session\Session;
use CL\TicketingBundle\Entity\Purchase;

class HydratePurchase
{
  private $session;
  private $serviceGenerateCode;
  private $serviceAddedPrices;

  public function __construct(
    Session $session,
    GenerateCodeWithDate $serviceGenerateCode,
    AddedPrices $serviceAddedPrices
    )
  {
    $this->session = $session;
    $this->serviceGenerateCode = $serviceGenerateCode;
    $this->serviceAddedPrices = $serviceAddedPrices;
  }

  public function hydrate(Purchase $purchase)
  {
    $purchase = $this->session->get('Purchase');
    // $date = strtotime($purchase->getVisitDate());
    $date = $purchase->getVisitDate();

    if (is_string($date))
    {
    $date = strtotime($purchase->getVisitDate());
    }

    $date = date('Y/m/d');
    // dump($date);die;

    $purchaseCode = $this
      ->serviceGenerateCode
      ->createPurchaseCode($purchase->getCreatedAt());

    $tickets = $purchase->getTickets();
    $totalPrice = $this
      ->serviceAddedPrices
      ->totalPrice($tickets);


    $purchase->setVisitDate(new \DateTime($date));
    $purchase->setCode($purchaseCode);
    $purchase->setPrice($totalPrice);
    }

}
