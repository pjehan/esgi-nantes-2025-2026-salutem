<?php

namespace App\EventSubscriber;

use App\Entity\Appointment;
use App\Event\AppointmentCreatedEvent;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class AppointmentSubscriber implements EventSubscriberInterface
{
    public function __construct(private readonly LoggerInterface $logger)
    {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            AppointmentCreatedEvent::class => 'onAppointmentCreated',
        ];
    }

    public function onAppointmentCreated(AppointmentCreatedEvent $event): void
    {
        $appointment = $event->getAppointment();
        $this->logger->info('Appointment created: ' . $appointment->getFirstName() . ' ' . $appointment->getLastName());
    }
}
