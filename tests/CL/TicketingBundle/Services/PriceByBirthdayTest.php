<?php
// tests/CL/TicketingBundle/Services/AddedPricesTest.php
namespace Test\CL\TicketingBundle\Service;

use PHPUnit\Framework\TestCase;
use CL\TicketingBundle\Entity\Ticket;
use CL\TicketingBundle\Services\PriceByBirthday;
use CL\TicketingBundle\TicketingConstants\TicketPrices;


class PriceByBirthdayTest extends TestCase
{
  /**
   * Test PriceByBirthday pour la journée
   */
  public function testDefineDayPriceByBirthday()
  {
    $priceByBirthday = new PriceByBirthday;

    $birthdayBaby = new \DateTime('25-10-2017');
    $birthdayChild = new \DateTime('25-10-2008');
    $birthdaySenior = new \DateTime('25-10-1956');
    $birthdayAdult = new \DateTime('25-10-1984');

    $result = $priceByBirthday->defineDayPrice($birthdayBaby);
    $this->assertSame(0, $result);

    $result = $priceByBirthday->defineDayPrice($birthdayChild);
    $this->assertSame(TicketPrices::CHILD_PRICE_DAY, $result);

    $result = $priceByBirthday->defineDayPrice($birthdaySenior);
    $this->assertSame(TicketPrices::SENIOR_PRICE_DAY, $result);

    $result = $priceByBirthday->defineDayPrice($birthdayAdult);
    $this->assertSame(TicketPrices::NORMAL_PRICE_DAY, $result);
  }

  /**
   * Test PriceByBirthday pour la demi-journée
   */
  public function testDefineHalfDayPriceByBirthday()
  {
    $priceByBirthday = new PriceByBirthday;

    $birthdayBaby = new \DateTime('25-10-2017');
    $birthdayChild = new \DateTime('25-10-2008');
    $birthdaySenior = new \DateTime('25-10-1956');
    $birthdayAdult = new \DateTime('25-10-1984');

    $result = $priceByBirthday->defineHalfDayPrice($birthdayBaby);
    $this->assertSame(0, $result);

    $result = $priceByBirthday->defineHalfDayPrice($birthdayChild);
    $this->assertSame(TicketPrices::CHILD_PRICE_HALF, $result);

    $result = $priceByBirthday->defineHalfDayPrice($birthdaySenior);
    $this->assertSame(TicketPrices::SENIOR_PRICE_HALF, $result);

    $result = $priceByBirthday->defineHalfDayPrice($birthdayAdult);
    $this->assertSame(TicketPrices::NORMAL_PRICE_HALF, $result);
  }

}
