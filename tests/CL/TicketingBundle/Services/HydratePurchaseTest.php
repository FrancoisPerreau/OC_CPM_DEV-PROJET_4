<?php
// tests/CL/TicketingBundle/Services/HydratePurchaseTest.php
namespace Test\CL\TicketingBundle\Service;

use PHPUnit\Framework\TestCase;

use Symfony\Component\HttpFoundation\Session\Storage\MockArraySessionStorage;
use Symfony\Component\HttpFoundation\Session\Session;

use CL\TicketingBundle\Services\AddedPrices;
use CL\TicketingBundle\Services\ConvertDatepickerInDatetime;
use CL\TicketingBundle\Services\GenerateCodeWithDate;
use CL\TicketingBundle\Services\HydratePurchase;

use CL\TicketingBundle\Entity\Purchase;
use CL\TicketingBundle\Entity\Ticket;



class HydratePurchaseTest extends TestCase
{

  /**
   * Test Hydrate Purchase
   */
  public function testHydratePurchaseBySession()
  {
    // Purchase ------------------------------
    $purchase = new Purchase;
    $purchaseCreatedAt = $purchase->setCreatedAt(new \DateTime('12-03-2019'));
    $purchaseVisitDate = $purchase->setVisitDate('08-05-2019');

    $ticketOne = new Ticket;
    $ticketOne->setPrice(10);

    $ticketTwo = new Ticket;
    $ticketTwo->setPrice(12);

    $purchase->addTicket($ticketOne);
    $purchase->addTicket($ticketTwo);


    // Session ------------------------------
    // $session = new Session(new MockArraySessionStorage());
    // $session->set('Purchase', $purchase);

    // ServiceGenerateCode ------------------
    $purchaseCode = 'C-20200225-3FB86D80';
    $ticketCode = 'T-20200225-3FB86D81';

    $serviceGenerateCode = $this
      -> getMockBuilder('CL\TicketingBundle\Services\GenerateCodeWithDate')
      ->disableOriginalConstructor()
      ->setMethods(['createPurchaseCode', 'createTicketCode'])
      ->getMock();
    $serviceGenerateCode
      ->method('createPurchaseCode')
      ->willReturn($purchaseCode);
    $serviceGenerateCode
      ->method('createTicketCode')
      ->willReturn($ticketCode);

    // ServiceAddedPrices --------------------
    $serviceAddedPrices = new AddedPrices;

    // ServiceConvertDatePicker --------------
    $serviceConvertDatePicker = new ConvertDatepickerInDatetime('fr');


    // HydratePurchase
    $hydratePurchase = new HydratePurchase($serviceGenerateCode, $serviceAddedPrices, $serviceConvertDatePicker);


    // Assertions --------------
    // -------------------------
    $hydratePurchase->hydrate($purchase);

    // Test hydratation visitDate
    $dateToCompare = new \DateTime('08-05-2019');
    $dateToCompare = $dateToCompare->format('Y-m-m');

    $purchaseDate = $purchase->getVisitDate();
    $purchaseDate = $purchaseDate->format('Y-m-m');

    $this->assertEquals($dateToCompare, $purchaseDate);


    // Test hydratation code
    $this->assertSame($purchaseCode, $purchase->getCode());

    // Test hydratation price
    $this->assertSame(22, $purchase->getPrice());
  }

}
