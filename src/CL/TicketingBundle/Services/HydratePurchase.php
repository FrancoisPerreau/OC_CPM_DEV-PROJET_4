<?php
// src/CL/TicketingBundle/Services/Ticket/hydratePurchase.php

namespace CL\TicketingBundle\Services;

use CL\TicketingBundle\Entity\Purchase;

class HydratePurchase
{
  private $serviceGenerateCode;
  private $serviceAddedPrices;

  public function __construct(
    GenerateCodeWithDate $serviceGenerateCode,
    AddedPrices $serviceAddedPrices
    )
  {

    $this->serviceGenerateCode = $serviceGenerateCode;
    $this->serviceAddedPrices = $serviceAddedPrices;
  }

  public function hydrate(Purchase $purchase)
  {

    $purchaseCode = $this
      ->serviceGenerateCode
      ->createPurchaseCode($purchase->getCreatedAt());

    $tickets = $purchase->getTickets();
    $totalPrice = $this
      ->serviceAddedPrices
      ->totalPrice($tickets);

    $purchase->setCode($purchaseCode);
    $purchase->setPrice($totalPrice);
    }

}
