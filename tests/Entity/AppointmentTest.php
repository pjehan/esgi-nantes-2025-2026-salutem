<?php

namespace App\Tests\Entity;

use App\Entity\Appointment;
use App\Entity\Doctor;
use App\Enum\AppointmentStatus;
use PHPUnit\Framework\TestCase;

class AppointmentTest extends TestCase
{
    public function testStatusIsPending(): void
    {
        $now = new \DateTimeImmutable();
        $appointment = new Appointment();
        $appointment->setDate($now->modify('+1 day'));
        $this->assertEquals(AppointmentStatus::PENDING, $appointment->getStatus());
        $appointment->setDate($now->modify('-2 day'));
        $this->assertNotEquals(AppointmentStatus::PENDING, $appointment->getStatus());
    }

    public function testStatusIsConfirmed(): void
    {
        $now = new \DateTimeImmutable();
        $appointment = new Appointment();
        $appointment->setDate($now->modify('+1 day'));
        $appointment->setDoctor(new Doctor());
        $this->assertEquals(AppointmentStatus::CONFIRMED, $appointment->getStatus());
        $appointment->setDate($now->modify('-2 day'));
        $this->assertNotEquals(AppointmentStatus::CONFIRMED, $appointment->getStatus());
    }
}
