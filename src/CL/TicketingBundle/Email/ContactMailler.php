<?php
// src/CL/TicketingBundle/Email/ContactMailler.php

namespace CL\TicketingBundle\Email;
use Symfony\Component\Templating\EngineInterface;


class ContactMailler
{
  private $mailer;
  protected $templating;


  function __construct(\Swift_Mailer $mailer, EngineInterface $templating)
  {
    $this->mailer = $mailer;
    $this->templating = $templating;
  }

  public function sendContactmail($formData)
  {
    // $firstname = $formData["firstname"];
    // $lastname = $formData["lastname"];
    $email = $formData["email"];
    // $sbject = $formData["subject"];
    // $message = $formData["message"];

    $message = new \Swift_Message(
      'Message de la billetterie du louvre'
    );

    $message
      ->setFrom($email)
      ->setTo('f.perreau@orange.fr')
      ->setBody(
        $this->templating->render(
          '@CLTicketing/Ticketing/Emails/contact.html.twig', ['formData' => $formData]
          ),
        'text/html'
      );
      // dump($message);
      // die;
    $this->mailer->send($message);
  }
}
