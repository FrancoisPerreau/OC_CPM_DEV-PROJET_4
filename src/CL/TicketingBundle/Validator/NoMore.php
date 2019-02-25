<?php
// src/CL/TicketingBundle/Validator/DaysClosed.php
namespace CL\TicketingBundle\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class NoMore extends Constraint
{
  public $message = "Désolé, il n'y à plus assez de places disponibles ce jour là.";

  public function validatedBy()
  {
    return 'ticketing_noMore'; // Ici, on fait appel à l'alias du service
  }

  public function getTargets()
  {
      return self::CLASS_CONSTRAINT;
  }
  
}
