<?php

namespace App\Enum;

enum AppointmentStatus: string
{
    case PENDING = 'En attente';
    case CONFIRMED = 'Confirmé';
    case PASSED = 'Passé';
}
