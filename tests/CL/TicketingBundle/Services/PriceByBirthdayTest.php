<?php
// tests/CL/TicketingBundle/Services/AddedPricesTest.php
namespace Test\CL\TicketingBundle\Service;

use PHPUnit\Framework\TestCase;
use CL\TicketingBundle\Entity\Ticket;
use CL\TicketingBundle\Services\PriceByBirthday;


class PriceByBirthdayTest extends TestCase
{

  private $ticketPrices = [
    "normal_price_day" => 16,
    "normal_price_half" => 9,
    "child_price_day" => 8,
    "child_price_half" => 5,
    "senior_price_day" => 12,
    "senior_price_half" => 7,
    "reduced_price_day" => 10,
    "reduced_price_half" => 6
  ];

  private $ticketingAgeRanges = [
    "child_age_mini" => 4,
    "child_age_maxi" => 12,
    "senior_age_mini" => 60
  ];

  /**
   * Test PriceByBirthday pour la journée
   */
  public function testDefineDayPriceByBirthday()
  {

    $priceByBirthday = new PriceByBirthday($this->ticketingAgeRanges, $this->ticketPrices);

    $birthdayBaby = new \DateTime('25-10-2017');
    $birthdayChild = new \DateTime('25-10-2008');
    $birthdaySenior = new \DateTime('25-10-1956');
    $birthdayAdult = new \DateTime('25-10-1984');

    // $closedDays = $this->container->getParameter('ticketing_closed_days');
    // dump($closedDays);

    $result = $priceByBirthday->defineDayPrice($birthdayBaby);
    $this->assertSame(0, $result);

    $result = $priceByBirthday->defineDayPrice($birthdayChild);
    $this->assertSame($this->ticketPrices["child_price_day"], $result);

    $result = $priceByBirthday->defineDayPrice($birthdaySenior);
    $this->assertSame($this->ticketPrices["senior_price_day"], $result);

    $result = $priceByBirthday->defineDayPrice($birthdayAdult);
    $this->assertSame($this->ticketPrices["normal_price_day"], $result);
  }

  /**
   * Test PriceByBirthday pour la demi-journée
   */
  public function testDefineHalfDayPriceByBirthday()
  {
    $priceByBirthday = new PriceByBirthday($this->ticketingAgeRanges, $this->ticketPrices);

    $birthdayBaby = new \DateTime('25-10-2017');
    $birthdayChild = new \DateTime('25-10-2008');
    $birthdaySenior = new \DateTime('25-10-1956');
    $birthdayAdult = new \DateTime('25-10-1984');

    $result = $priceByBirthday->defineHalfDayPrice($birthdayBaby);
    $this->assertSame(0, $result);

    $result = $priceByBirthday->defineHalfDayPrice($birthdayChild);
    $this->assertSame($this->ticketPrices["child_price_half"], $result);

    $result = $priceByBirthday->defineHalfDayPrice($birthdaySenior);
    $this->assertSame($this->ticketPrices["senior_price_half"], $result);

    $result = $priceByBirthday->defineHalfDayPrice($birthdayAdult);
    $this->assertSame($this->ticketPrices["normal_price_half"], $result);
  }

}
