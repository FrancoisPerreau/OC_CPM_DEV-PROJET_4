<?php
// src/CL/TicketingBundle/Controller/TicketingController.php

namespace CL\TicketingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
// use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Routing\Annotation\Route;
// use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

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
          $session = new Session;
          // $session->start();
          $session->set('TicketDateChoiceFomData', $form->getData());
          // dump($session->get('TicketDateChoiceFomData'));die;
          // $_SESSION['TicketDateChoiceFomData'] = $form->getData();
          // dump($_SESSION['TicketDateChoiceFomData']);die;
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
        // dump($data);die;
        $ticketNb = $data['TicketNb'];
        // dump($ticketNb);die;
        $purchase = new Purchase;

        for ($i=0; $i < $ticketNb; $i++) {
            $ticket = new Ticket;
            // $this->container->get('cl_ticketing.hydrateTicket')->hydrate($ticket);

            $purchase->getTickets()->add($ticket);
        }



        $form = $this->createForm(PurchaseType::class, $purchase);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $formTicket = $form->getData();

            $tickets = $purchase->getTickets();
            foreach ($tickets as $ticket) {
                $this->container->get('cl_ticketing.hydrateTicket')->hydrate($ticket);
            }
            // dump($tickets); die;


            // // $tickets = $formTicket['Purchase'];
            // dump($tickets); die;


            // dump($formTicket);die;
            dump($purchase); die;

            $serviceDefinePrice = $this->container->get('cl_ticketing.definePriceByBirthday');

            $birthday = new \DateTime('2006-01-01');

            $priceDay = $serviceDefinePrice->defineDayPrice($birthday);
            dump($priceDay);die;

            // return $this->redirectToRoute('purchase_regitration');
        }


        return $this->render('@CLTicketing/Ticketing/purchase.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
