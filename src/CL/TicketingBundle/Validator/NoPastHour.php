<?php
// src/CL/TicketingBundle/Validator/NoPastHour.php
namespace CL\TicketingBundle\Validator;

use Symfony\Component\Validator\Constraint;


/**
 * @Annotation
 */
class NoPastHour extends Constraint
{
  public $message = "Après 16h30, vous ne pouvez plus commander billet pour le jour même.";

  public function validateBy()
  {
    return 'ticketing_noPastHour';
  }

  public function getTargets()
  {
      return self::CLASS_CONSTRAINT;
  }
}
