<?php
// tests/CL/TicketingBundle/Controller/TicketingControllerTest.php

namespace Tests\CL\TicketingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HTTPFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\BrowserKit\Cookie;

use Symfony\Component\HttpFoundation\Session\Storage\MockArraySessionStorage;


use CL\TicketingBundle\Entity\Purchase;


class TicketingControllerTest extends WebTestCase
{
  private $client;

  public function setUp()
  {
    $this->client = static::createClient();
  }

  //----------------------------------------------

  /**
   * Test homepage
   * Le statusCode de la page
   */
  public function testHomepageIsUp()
  {
    $this->client->request('GET', '/');

    $this->assertSame(200, $this->client->getResponse()->getStatusCode());
  }

  /**
   * Test homepage
   * Si il y a bien un H1
   */
  public function testHomepage()
  {
    $crawler = $this->client->request('GET', '/');
    $this->assertSame(1, $crawler->filter('h1')->count());
  }

  /**
   * Test homepage
   * Le formulaire et la redirection
   */
  public function testHomeChoiceDateAndTypeTycket()
  {
    $crawler = $this->client->request('GET', '/');

    $this->assertTrue($this->client->getResponse()->isSuccessful());

    $form = $crawler->selectButton('Réservez vos billets')->form();
    $form['cl_ticketingbundle_purchase[email][first]'] = 'b.morane@indochine.fr';
    $form['cl_ticketingbundle_purchase[email][second]'] = 'b.morane@indochine.fr';
    $form['cl_ticketingbundle_purchase[visitDate]'] = '14/03/2020';
    $form['cl_ticketingbundle_purchase[visitType]'] = 0;
    $form['cl_ticketingbundle_purchase[ticketNb]'] = 2;

    $this->client->submit($form);

    // echo $this->client->request('GET', '/')->html();
    // $this->assertSame(302, $this->client->getResponse()->getStatusCode());
    $this->assertTrue($this->client->getResponse()->isRedirection());
  }

  /**
   * Test homepage
   * Le lien vers la page Contact
   */
  public function testHomeLinkContact()
  {
    $crawler = $this->client->request('GET', '/');

    $link = $crawler->selectLink('Contact')->link();
    $crawler = $this->client->click($link);

    $info = $crawler->filter('h1')->text();
    // dump($info);die;

    $this->assertSame('Une question ?', $info);
  }

  /**
   * Test purchase_regitration
   * La redirection
   */
  public function testPurchaseRegitrationIsRedirect()
  {
    $this->client->request('GET', '/purchase');

    $this->assertSame(302, $this->client->getResponse()->getStatusCode());
  }

  /**
   * Test purchase_confirmation
   * La redirection
   */
  public function testPurchasConfirmationIsRedirect()
  {
    $this->client->request('GET', '/confirmation');

    $this->assertSame(302, $this->client->getResponse()->getStatusCode());
  }

  /**
   * Test purchase_thanks
   * La redirection
   */
  public function testThanksConfirmationIsRedirect()
  {
    $this->client->request('GET', '/thanks');

    $this->assertSame(302, $this->client->getResponse()->getStatusCode());
  }

  /**
   * Test ticketing_contact
   * Le statusCode de la page
   */
  public function testContactIsUp()
  {
    $this->client->request('GET', '/contact');

    $this->assertSame(200, $this->client->getResponse()->getStatusCode());
  }

}
