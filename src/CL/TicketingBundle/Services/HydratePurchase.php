<?php
// src/CL/TicketingBundle/Services/Ticket/hydratePurchase.php

namespace CL\TicketingBundle\Services;
use Symfony\Component\HttpFoundation\Session\Session;
use CL\TicketingBundle\Entity\Purchase;

class HydratePurchase
{
  private $serviceGenerateCode;
  private $serviceAddedPrices;
  private $serviceConvertDatePicker;

  public function __construct(
    GenerateCodeWithDate $serviceGenerateCode,
    AddedPrices $serviceAddedPrices,
    ConvertDatepickerInDatetime $serviceConvertDatePicker
    )
  {
    $this->serviceGenerateCode = $serviceGenerateCode;
    $this->serviceAddedPrices = $serviceAddedPrices;
    $this->serviceConvertDatePicker = $serviceConvertDatePicker;
  }

  /**
   * Hydrate Purchase
   * @param  Purchase $purchase
   */
  public function hydrate(Purchase $purchase)
  {
    $date = $purchase->getVisitDate();

    $date = $this->serviceConvertDatePicker
                 ->convertDatepicker($date);

    $purchaseCode = $this
      ->serviceGenerateCode
      ->createPurchaseCode($purchase->getCreatedAt());

    $tickets = $purchase->getTickets();
    $totalPrice = $this->serviceAddedPrices
                       ->totalPrice($tickets);


    $purchase->setVisitDate($date);
    $purchase->setCode($purchaseCode);
    $purchase->setPrice($totalPrice);
    }

}
