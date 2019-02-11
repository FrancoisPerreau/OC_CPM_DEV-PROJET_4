<?php

namespace CL\TicketingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
// use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Routing\Annotation\Route;
// use Symfony\Component\HttpFoundation\Response;

use CL\TicketingBundle\Form\TicketDateChoiceType;


class TicketingController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
      $form = $this->createForm(TicketDateChoiceType::class);
      $form->handleRequest($request);

      if ($form->isValid() && $form->isSubmitted())
      {
          $_SESSION['data'] = $form->getData();
          // dump($_SESSION['data']);die;
          return $this->redirectToRoute('order_regitration');
      }

      return $this->render('@CLTicketing/Ticketing/homepage.html.twig',[
          'form' => $form->createView(),
      ]);
    }


    /**
     * @Route("/order", name="order_regitration")
     */
    public function orderAction(Request $request)
    {
        $data = $_SESSION['data'];
        // $nbTicket = $request->get('TicketNb');
        return $this->render('@CLTicketing/Ticketing/order.html.twig', [
            'data' => $data
        ]);
    }
}
