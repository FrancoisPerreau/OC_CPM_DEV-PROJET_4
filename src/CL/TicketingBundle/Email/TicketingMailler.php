<?php
// src/CL/TicketingBundle/Email/TicketingMailler.php

namespace CL\TicketingBundle\Email;

use Symfony\Component\Templating\EngineInterface;

use CL\TicketingBundle\Entity\Purchase;


class TicketingMailler
{
  private $mailer;
  protected $templating;


  function __construct(\Swift_Mailer $mailer, EngineInterface $templating)
  {
    $this->mailer = $mailer;
    $this->templating = $templating;
  }

  public function sendPurchaseNotification(Purchase $purchase)
  {
    $message = new \Swift_Message(
      'Merci de votre commande',
      'Voici le détail:'
    );

    $message
      ->setFrom('billetterie@louvre.fr')
      ->setTo($purchase->getEmail())
      ->setBody(
        $this->templating->render(
          '@CLTicketing/Ticketing/Emails/notification.html.twig', ['purchase' => $purchase]
          ),
        'text/html'
      );
      // dump($message);
      // die;
    $this->mailer->send($message);
  }
}
