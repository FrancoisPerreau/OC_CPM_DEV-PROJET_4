<?php
// src/CL/TicketingBundle/Controller/TicketingController.php

namespace CL\TicketingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
// use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Routing\Annotation\Route;
// use Symfony\Component\HttpFoundation\Response;

use CL\TicketingBundle\Entity\Purchase;
use CL\TicketingBundle\Entity\Ticket;

use CL\TicketingBundle\Form\TicketDateChoiceType;
use CL\TicketingBundle\Form\PurchaseType;


class TicketingController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
      $form = $this->createForm(TicketDateChoiceType::class);
      $form->handleRequest($request);

      if ($form->isSubmitted() && $form->isValid())
      {
          $_SESSION['data'] = $form->getData();
          // dump($_SESSION['data']);die;
          return $this->redirectToRoute('purchase_regitration');
      }

      return $this->render('@CLTicketing/Ticketing/homepage.html.twig',[
          'form' => $form->createView(),
      ]);
    }


    /**
     * @Route("/purchase", name="purchase_regitration")
     */
    public function orderAction(Request $request)
    {
        $data = $_SESSION['data'];
        // dump($data);die;
        $ticketNb = $data['TicketNb'];
        // dump($ticketNb);die;
        $purchase = new Purchase;
        // $ticket = new Ticket;

        for ($i=0; $i < $ticketNb; $i++) {
            $ticket = new Ticket;
            $purchase->getTickets()->add($ticket);
        }



        $form = $this->createForm(PurchaseType::class, $purchase);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $formTicket = $form->getData();
            dump($formTicket);die;
            // return $this->redirectToRoute('purchase_regitration');
        }


        return $this->render('@CLTicketing/Ticketing/purchase.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
