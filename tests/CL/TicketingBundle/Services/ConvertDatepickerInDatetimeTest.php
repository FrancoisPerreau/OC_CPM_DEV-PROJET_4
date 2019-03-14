<?php
// tests/CL/TicketingBundle/Services/ConvertDatepickerInDatetimeTest.php
namespace Test\CL\TicketingBundle\Servives;

use PHPUnit\Framework\TestCase;
use CL\TicketingBundle\Services\ConvertDatepickerInDatetime;

class ConvertDatepickerInDatetimeTest extends TestCase
{
  /**
   * Test ConvertDatepickerInDatetime
   * Si la locale est fr
   */
  public function testConvertDatepickerLocaleTypeFr()
  {
    $convertDatepickerInDatetime = new ConvertDatepickerInDatetime('fr');
    $date = '08/05/2019';
    $dateTocompare = new \DateTime('08-05-2019');
    $dateTocompare = $dateTocompare->format('d/m/Y');

    $result = $convertDatepickerInDatetime->convertDatepicker($date);
    $result = $result->format('d/m/Y');

    $this->assertSame($dateTocompare, $result);
  }

  /**
   * Test ConvertDatepickerInDatetime
   * Si la locale est en
   */
  public function testConvertDatepickerLocaleTypeEn()
  {
    $convertDatepickerInDatetime = new ConvertDatepickerInDatetime('en');
    $date = '05/08/2019';
    $dateTocompare = new \DateTime('08-05-2019');
    $dateTocompare = $dateTocompare->format('d/m/Y');

    $result = $convertDatepickerInDatetime->convertDatepicker($date);
    $result = $result->format('d/m/Y');

    $this->assertSame($dateTocompare, $result);
  }
}
