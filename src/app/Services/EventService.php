<?php

namespace App\Services;

use App\Models\Event;
use Carbon\Carbon;

class EventService
{
  public function checkEventDuplication($eventDate, $startTime, $endTime)
  {
    $isCheck = Event::whereDate('start_date', $eventDate)
            ->whereTime('end_date', '>', $startTime)
            ->whereTime('start_date', '<', $endTime)
            ->exists();

    return $isCheck;
  }

  public function countEventDuplication($eventDate, $startTime, $endTime)
  {
    $count = Event::whereDate('start_date', $eventDate)
            ->whereTime('end_date', '>', $startTime)
            ->whereTime('start_date', '<', $endTime)
            ->count();

    return $count;
  }

  public function joinDateAndTime($date, $time)
  {
    $join = $date . " " . $time;
    $dateTime = Carbon::createFromFormat('Y-m-d H:i', $join);

    return $dateTime;
  }
}