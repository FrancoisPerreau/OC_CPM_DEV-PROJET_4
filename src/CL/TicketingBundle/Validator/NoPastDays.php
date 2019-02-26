<?php
// src/CL/TicketingBundle/Validator/DaysClosed.php
namespace CL\TicketingBundle\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class NoPastDays extends Constraint
{
  public $message = "Désolé, cette date est déjà passée.";

  public function validateBy()
  {
    return 'ticketing_noPastDays';
  }
}
