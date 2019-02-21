<?php
// src/CL/TicketingBundle/Controller/TicketingController.php

namespace CL\TicketingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
// use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Routing\Annotation\Route;
// use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
// use Doctrine\Common\Collections\ArrayCollection;

use CL\TicketingBundle\Entity\Purchase;
use CL\TicketingBundle\Entity\Ticket;

use CL\TicketingBundle\Form\PurchaseDateChoiceType;
use CL\TicketingBundle\Form\PurchaseTicketType;
use CL\TicketingBundle\Form\PurchaseEmailType;



class TicketingController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
      $purchase = new Purchase;

      $form = $this->createForm(PurchaseDateChoiceType::class, $purchase);
      $form->handleRequest($request);

      if ($form->isSubmitted() && $form->isValid())
      {
          $session = new Session;
          $session->set('Purchase', $form->getData());
          // dump($purchase);die;
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
        $session = new Session;
        $purchase = $session->get('Purchase');
        $tickets = $purchase->getTickets();
        // dump(count($tickets));
        // die;
        $ticketNb = $purchase->getTicketNb();
        // dump($ticketNb);die;


        // Collection de formulaires
        if (count($tickets) === 0) {
            for ($i=0; $i < $ticketNb; $i++) {
                $ticket = new Ticket;

                $purchase->addTicket($ticket);
            }
        }

        // dump($ticketNb);die;
        // dump($purchase);die;
        $form = $this->createForm(PurchaseTicketType::class, $purchase);
        $form->handleRequest($request);
        // dump($ticketNb);die;
        if ($form->isSubmitted() && $form->isValid())
        {
            // dump($ticketNb);
            // dump($purchase);
            // $formTicket = $form->getData();
            // dump($purchase);die;
            $tickets = $purchase->getTickets();

            // dump($purchase);
            // dump($tickets);
            // die;

            // Hydrate le ou les Ticket(s)
            foreach ($tickets as $ticket)
            {
                $this->container->get('cl_ticketing.hydrateTicket')->hydrate($ticket);
            }

            // dump($purchase);
            // dump($tickets);
            // die;

            // Hydrate Purchase
            $this->container->get('cl_ticketing.hydratePurchase')->hydrate($purchase);

            // dump($purchase);
            // dump($tickets);
            // die;

            // $session = new Session;
            $session->set('Purchase', $purchase);
            // dump($formTicket); die;

            return $this->redirectToRoute('purchase_confirmation');
        }

        return $this->render('@CLTicketing/Ticketing/purchase.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/confirmation", name="purchase_confirmation")
     */
    public function confirmationAction(Request $request)
    {
        $session = new Session;
        $purchase = $session->get('Purchase');

      $form = $this->createForm(PurchaseEmailType::class, $purchase);
      $form->handleRequest($request);

      if ($form->isSubmitted() && $form->isValid())
      {
          $data = $form->getData();

          $session = new Session;
          $purchase = $session->get('Purchase');
          // $tickets =$purchase->getTickets();

          // $purchase->setEmail($data['email']);

          // $today = new \Datetime('today');
          // dump($today->format('w'));die;

          // dump($data);
          // dump($purchase);die;
          // $manager = $this->container->get('cl_ticketing.manager');



          dump($purchase);die;
          $this->container->get('cl_ticketing.manager')->save($purchase);

          return $this->redirectToRoute('homepage');
      }


        return $this->render('@CLTicketing/Ticketing/confirmation.html.twig', [
            'form'=> $form->createView(),
            'purchase' => $purchase
        ]

    );
    }
}
