<?php
// src/CL/TicketingBundle/Validator/DaysClosed.php
namespace CL\TicketingBundle\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class NoTuesday extends Constraint
{
  public $message = "Désolé, le musée est fermé le mardi.";
}
