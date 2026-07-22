<?php

namespace App\Event;

use App\Entity\Appointment;
use Symfony\Contracts\EventDispatcher\Event;

class AppointmentCreatedEvent extends Event
{
    public function __construct(private readonly Appointment $appointment)
    {
    }

    public function getAppointment(): Appointment
    {
        return $this->appointment;
    }
}
