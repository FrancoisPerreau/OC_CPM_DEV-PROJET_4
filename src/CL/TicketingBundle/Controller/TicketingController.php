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
        $session = new Session;
        $session->invalidate();

        $purchase = new Purchase;

        $form = $this->createForm(PurchaseDateChoiceType::class, $purchase);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $session = new Session;
            $session->set('Purchase', $form->getData());

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
        $ticketNb = $purchase->getTicketNb();


        // Collection de formulaires
        if (count($tickets) === 0)
        {
            for ($i=0; $i < $ticketNb; $i++)
            {
                $ticket = new Ticket;
                $purchase->addTicket($ticket);
            }
        }


        $form = $this->createForm(PurchaseTicketType::class, $purchase);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $tickets = $purchase->getTickets();

            // Hydrate le ou les Ticket(s)
            foreach ($tickets as $ticket)
            {
                $this->container->get('cl_ticketing.hydrateTicket')->hydrate($ticket);
            }

            // Hydrate Purchase
            $this->container->get('cl_ticketing.hydratePurchase')->hydrate($purchase);

            // $session = new Session;
            $session->set('Purchase', $purchase);

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
            // $data = $form->getData();
            $session = new Session;
            $purchase = $session->get('Purchase');

            // dump($purchase);die;

            $this->container->get('cl_ticketing.manager')->save($purchase);

            $this->addFlash('success', 'Votre commande a bien enregistrée !');

            return $this->redirectToRoute('purchase_confirmation');
        }


        return $this->render('@CLTicketing/Ticketing/confirmation.html.twig', [
            'form'=> $form->createView(),
            'purchase' => $purchase
        ]

    );
    }
}
