<?php
// src/CL/TicketingBundle/Controller/TicketingController.php

namespace CL\TicketingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Config\Definition\Exception\Exception;

use CL\TicketingBundle\Entity\Purchase;
use CL\TicketingBundle\Entity\Ticket;
use CL\TicketingBundle\TicketingConstants\TicketPrices;
use CL\TicketingBundle\TicketingConstants\AgeRanges;
use CL\TicketingBundle\TicketingConstants\DayClosedAndHourLimit;

use CL\TicketingBundle\Form\PurchaseDateChoiceType;
use CL\TicketingBundle\Form\PurchaseTicketType;
use CL\TicketingBundle\Form\ContactType;
// use CL\TicketingBundle\Form\PurchaseEmailType;



class TicketingController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // On vide la session en arrivant sur la home
        $session = $this->get('session');
        $session->remove('Purchase');
        $session->remove('PurchaseTickets');

        // $session->invalidate();
        $session->start();


        $purchase = new Purchase;
        $TicketPrices = new TicketPrices;
        $AgeRanges = new AgeRanges;
        $DayClosedAndHourLimit = new DayClosedAndHourLimit;


        // Formulaire
        $form = $this->createForm(PurchaseDateChoiceType::class, $purchase);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $session->set('Purchase', $form->getData());
            return $this->redirectToRoute('purchase_regitration');
        }

        return $this->render('@CLTicketing/Ticketing/homepage.html.twig',[
        'form' => $form->createView(),
        'TicketPrices' => $TicketPrices,
        'AgeRanges' => $AgeRanges,
        'HourLimit' => $DayClosedAndHourLimit
        ]);
    }


    /**
     * @Route("/purchase", name="purchase_regitration")
     */
    public function orderAction(Request $request)
    {
        $session = $this->get('session');
        $purchase = $session->get('Purchase');

        // Si la session n'existe pas on retourne à la home
        if (!$purchase) {
          return $this->redirectToRoute('homepage');
        }


        // Collection de formulaires,
        // Création des instances de Ticket en fonction du nb renseigné
        $tickets = $purchase->getTickets();
        $ticketNb = $purchase->getTicketNb();

        if (count($tickets) === 0)
        {
            for ($i=0; $i < $ticketNb; $i++)
            {
                $ticket = new Ticket;
                $purchase->addTicket($ticket);
            }
        }


        // Formulaire
        $form = $this->createForm(PurchaseTicketType::class, $purchase);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $visitDate = $purchase->getVisitDate();
            $visitType = $purchase->getVisitType();
            $tickets = $purchase->getTickets();

            // Hydrate le ou les Ticket(s)
            foreach ($tickets as $ticket)
            {
                $this->container->get('cl_ticketing.hydrateTicket')->hydrate($ticket, $visitDate, $visitType);
            }

            // Hydrate Purchase
            $this->container->get('cl_ticketing.hydratePurchase')->hydrate($purchase);

            $session->set('PurchaseTickets', $purchase);

            return $this->redirectToRoute('purchase_confirmation');
        }

        return $this->render('@CLTicketing/Ticketing/purchase.html.twig', [
            'form' => $form->createView(),
            'purchase' => $purchase
        ]);
    }


    /**
     * @Route("/confirmation", name="purchase_confirmation")
     */
    public function confirmationAction()
    {
        $session = $this->get('session');
        $purchase = $session->get('PurchaseTickets');

        // Si la session n'existe pas on retourne à la home
        if (!$purchase)
        {
          return $this->redirectToRoute('homepage');
        }

        return $this->render('@CLTicketing/Ticketing/confirmation.html.twig', [
            'purchase' => $purchase
        ]);
    }


    /**
     * @Route("/thanks", name="purchase_thanks")
     */
    public function thanksAction(Request $request)
    {
        $data = $request->request->all();

        // Si le stripeToken n'existe pas on retourne à la home
        if (!isset($data['stripeToken'])) {
            return $this->redirectToRoute('homepage');
        }

        $session = $this->get('session');
        $purchase = $session->get('PurchaseTickets');

        $stripeToken = $data['stripeToken'];


        // Si le stripeToken existe on effectue le payement
        \Stripe\Stripe::setApiKey("sk_test_QLXj1J6fsBOBO2vsXejztsOO");

        $charge = \Stripe\Charge::create([
            'amount' => $purchase->getPrice() * 100,
            'currency' => 'eur',
            'description' => 'Billetterie',
            'source' => $stripeToken,
        ]);

        // On associe l'id de la charge Stripe à Purchase
        $chargeId = $charge['id'];
        $purchase->setStripeChargeId($chargeId);

        // Et on entre la commande en BDD
        $this->container->get('cl_ticketing.manager')->save($purchase);

        $this->addFlash('success', 'Votre commande a bien été enregistrée !');


        return $this->render('@CLTicketing/Ticketing/thanks.html.twig',[
            'purchase' => $purchase
        ]);
    }


    /**
     * @Route("/contact", name="ticketing_contact")
     */
    public function contactAction(Request $request)
    {
        //Formulaire
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $formData = $form->getData();

            try {
                $this->container
                    ->get('cl_ticketing.email.contactMailler')
                    ->sendContactmail($formData);

                $this->addFlash('successContact', 'Votre message à bien été envoyé');

            }
            catch (\Exception $e)
            {
                throw new Exception("Une erreur est survenue lors de l'envoi de votre message");

                $this->addFlash('echecContact',$e->getMessage());
            }
        }

        return $this->render('@CLTicketing/Ticketing/contact.html.twig',[
            'form' => $form->createView()
        ]);
    }

}
