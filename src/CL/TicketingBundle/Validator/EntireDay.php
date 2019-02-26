<?php
// src/CL/TicketingBundle/Validator/EntireDay.php
namespace CL\TicketingBundle\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class EntireDay extends Constraint
{
  public $message = "Après 14h00, vous ne pouvez plus choisir un billet à la journée pour le jour même.";

  public function validateBy()
  {
    return 'ticketing_entireDay';
  }

  public function getTargets()
  {
      return self::CLASS_CONSTRAINT;
  }
}
