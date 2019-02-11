<?php

namespace CL\TicketingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
// use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Routing\Annotation\Route;

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
          dump($_POST);die;
      }

      return $this->render('@CLTicketing/Ticketing/homepage.html.twig',[
          'form' => $form->createView(),
      ]);
    }
}
