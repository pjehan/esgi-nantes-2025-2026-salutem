<?php

namespace App\Controller\Admin;

use App\Entity\Appointment;
use App\Enum\AppointmentStatus;
use App\Form\AppointmentDoctorType;
use App\Repository\AppointmentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AppointmentController extends AbstractController
{
    #[Route('/admin/appointment', name: 'app_admin_appointment')]
    public function index(AppointmentRepository $appointmentRepository, FormFactoryInterface $formFactory): Response
    {
        $appointments = $appointmentRepository->findBy([], ['date' => 'DESC']);
        $forms = [];

        foreach ($appointments as $appointment) {
            if ($appointment->getStatus() === AppointmentStatus::PENDING) {
                $forms[$appointment->getId()] = $formFactory->createNamed('appointment_' . $appointment->getId(), AppointmentDoctorType::class, $appointment, ['action' => $this->generateUrl('app_admin_appointment_assign_doctor', ['id' => $appointment->getId()])])->createView();
            }
        }

        return $this->render('admin/appointment/index.html.twig', [
            'appointments' => $appointments,
            'forms' => $forms,
        ]);
    }

    #[Route('/admin/appointment/{id}/assign-doctor', name: 'app_admin_appointment_assign_doctor', methods: ['POST'])]
    public function assignDoctor(Request $request, EntityManagerInterface $em, FormFactoryInterface $formFactory, Appointment $appointment): Response
    {
        $form = $formFactory->createNamed('appointment_' . $appointment->getId(), AppointmentDoctorType::class, $appointment);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($appointment);
            $em->flush();
        }

        return $this->redirectToRoute('app_admin_appointment');
    }
}
