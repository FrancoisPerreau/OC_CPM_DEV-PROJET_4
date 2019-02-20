<?php
// src/CL/TicketingBundle/Validator/DaysClosed.php
namespace CL\TicketingBundle\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class IsOpen extends Constraint
{
  public $message = "Désolé, le musée est fermé ce jour là";
}
