<?php
// src/CL/TicketingBundle/Services/DefinePaques.php

namespace CL\TicketingBundle\Services;

class DefinePaques
{


  public function paquesByYear ($year)
  {
    // Calcule du dimanche de Pâques
    $a = $year % 4;
    $b = $year % 7;
    $c = $year % 19;
    $m = 24;
    $n = 5;
    $d = (19 * $c + $m ) % 30;
    $e = (2 * $a + 4 * $b + 6 * $d + $n) % 7;

    $easterdate = 22 + $d + $e;

    if ($easterdate > 31)
    {
            $day = $d + $e - 9;
            $month = 4;
    }
    else
    {
            $day = 22 + $d + $e;
            $month = 3;
    }

    if ($d == 29 && $e == 6)
    {
            $day = 10;
            $month = 04;
    }
    elseif ($d == 28 && $e == 6)
    {
            $day = 18;
            $month = 04;
    }

    return new \Datetime($day . '-' . $month . '-' . $year);
  }


  public function defineMondayPaques($year)
  {
    $sundayPaques = $this->paquesByYear($year);
    $mondayPaques = $sundayPaques->add(new \DateInterval('P1D'));

    return $mondayPaques;
  }


}
