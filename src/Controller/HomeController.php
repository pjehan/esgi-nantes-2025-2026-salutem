<?php

namespace App\Controller;

use App\Entity\Appointment;
use App\Entity\User;
use App\Event\AppointmentCreatedEvent;
use App\Form\AppointmentType;
use App\Repository\DoctorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(
        #[CurrentUser] ?User $user,
        Request $request,
        DoctorRepository $doctorRepository,
        EntityManagerInterface $em,
        EventDispatcherInterface $eventDispatcher
    ): Response
    {
        $doctors = $doctorRepository->findDoctorsWithSpecialties();

        $appointment = new Appointment();
        $appointmentForm = $this->createForm(AppointmentType::class, $appointment);

        $appointmentForm->handleRequest($request);
        if ($appointmentForm->isSubmitted() && $appointmentForm->isValid()) {
            $date = $appointmentForm->get('date_start')->getData();
            $time = $appointmentForm->get('time_start')->getData();
            $appointment->setDate(new \DateTimeImmutable($date->format('Y-m-d') . ' ' . $time->format('H:i:s')));

            $appointment->setUser($user);

            $em->persist($appointment);
            $em->flush();

            $this->addFlash('info', 'Votre rendez-vous a été correctement enregistré');
            $eventDispatcher->dispatch(new AppointmentCreatedEvent($appointment));

            return $this->redirectToRoute('app_home');
        }

        return $this->render('home/index.html.twig', [
            'doctors' => $doctors,
            'appointmentForm' => $appointmentForm,
        ]);
    }
}
