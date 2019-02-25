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
  private $serviceConvertDatePicker;

  public function __construct(
    Session $session,
    GenerateCodeWithDate $serviceGenerateCode,
    AddedPrices $serviceAddedPrices,
    ConvertDatepickerInDatetime $serviceConvertDatePicker
    )
  {
    $this->session = $session;
    $this->serviceGenerateCode = $serviceGenerateCode;
    $this->serviceAddedPrices = $serviceAddedPrices;
    $this->serviceConvertDatePicker = $serviceConvertDatePicker;
  }

  public function hydrate(Purchase $purchase)
  {
    $purchase = $this->session->get('Purchase');
    $date = $purchase->getVisitDate();

    $date = $this->serviceConvertDatePicker
                 ->convertDatepicker($date);
    // dump($date);die;

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
