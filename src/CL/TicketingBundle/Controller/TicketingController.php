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

use CL\TicketingBundle\Form\TicketDateChoiceType;
use CL\TicketingBundle\Form\PurchaseType;
use CL\TicketingBundle\Form\EmailvalidationType;



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
          $session = new Session;
          $session->set('TicketDateChoiceFomData', $form->getData());

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
        $data = $session->get('TicketDateChoiceFomData');

        $ticketNb = $data['TicketNb'];
        $purchase = new Purchase;

        // Collection de formulaires
        for ($i=0; $i < $ticketNb; $i++) {
            $ticket = new Ticket;

            $purchase->addTicket($ticket);
        }
        // dump($purchase);die;
        $form = $this->createForm(PurchaseType::class, $purchase);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $formTicket = $form->getData();
            $tickets = $purchase->getTickets();

            // Hydrate le ou les Ticket(s)
            foreach ($tickets as $ticket)
            {
                $this->container->get('cl_ticketing.hydrateTicket')->hydrate($ticket);
            }

            // Hydrate Purchase
            $this->container->get('cl_ticketing.hydratePurchase')->hydrate($purchase);

            // $session = new Session;
            $session->set('savePurchase', $purchase);

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
      $form = $this->createForm(EmailvalidationType::class);
      $form->handleRequest($request);

      if ($form->isSubmitted() && $form->isValid())
      {
          $data = $form->getData();

          $session = new Session;
          $purchase = $session->get('savePurchase');
          $tickets =$purchase->getTickets();

          $purchase->setEmail($data['email']);

          // $today = new \Datetime('today');
          // dump($today->format('w'));die;

          // dump($data);
          // dump($purchase);die;
          // $manager = $this->container->get('cl_ticketing.manager');

          // $manager->myPersist($purchase);
          // $manager->myPersist($tickets);
          //
          // $manger->myFlush();

          // $em = $this->getDoctrine()->getManager();
          // $em->persist($purchase);
          // $em->flush();

          $this->container->get('cl_ticketing.manager')->save($purchase);

          return $this->redirectToRoute('homepage');
      }


        return $this->render('@CLTicketing/Ticketing/confirmation.html.twig', [
            'form'=> $form->createView()
        ]);
    }
}
