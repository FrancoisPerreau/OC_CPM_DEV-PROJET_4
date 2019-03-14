<?php
// tests/CL/TicketingBundle/Services/AddedPricesTest.php
namespace Test\CL\TicketingBundle\Service;

use PHPUnit\Framework\TestCase;
use CL\TicketingBundle\Entity\Ticket;
use CL\TicketingBundle\Services\AddedPrices;


class AddedPricesTest extends TestCase
{
  /**
   * Test AddedPrices
   */
  public function testAddPricesTickets()
  {
    $addPrices = new AddedPrices;

    $ticketOne = new Ticket;
    $ticketOne->setPrice(10);

    $ticketTwo = new Ticket;
    $ticketTwo->setPrice(12);

    $tickets = [
      'ticketOne' => $ticketOne,
      'ticketTwo' => $ticketTwo
    ];

    $result = $addPrices->totalPrice($tickets);

    $this->assertSame(22, $result);
  }

}
