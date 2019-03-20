<?php
// src/CL/TicketingBundle/TicketingConstants/DayClosedAndHourLimit.php

namespace CL\TicketingBundle\TicketingConstants;

final class DayClosedAndHourLimit
{
  const HALF_DAY_HOUR = 14;
  const PAST_DAY_HOUR = 16.30;

  const DAYS_CLOSED = [
    "01-01",
    "05-01",
    "05-08",  
    "07-14",
    "08-15",
    "11-01",
    "11-11",
    "12-25"
  ];
  const PAQUES_CLOSED = true;
  const ASCENSION_CLOSED = true;
  const PENTECOTE_CLOSED = true;
}
