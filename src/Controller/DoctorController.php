<?php

namespace App\Controller;

use App\Entity\Doctor;
use App\Form\DoctorType;
use App\Repository\DoctorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class DoctorController extends AbstractController
{
    #[Route('/doctors', name: 'app_doctors')]
    public function index(DoctorRepository $doctorRepository): Response
    {
        $doctors = $doctorRepository->findAll();

        return $this->render('doctor/index.html.twig', [
            'doctors' => $doctors,
        ]);
    }

    #[Route('/doctor/{id}', name: 'app_doctor_show', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function show(Doctor $doctor): Response
    {
        return $this->render('doctor/show.html.twig', [
            'doctor' => $doctor,
        ]);
    }

    #[Route('/doctor/new', name: 'app_doctor_new', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $doctor = new Doctor();
        $form = $this->createForm(DoctorType::class, $doctor);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($doctor);
            $em->flush();

            return $this->redirectToRoute('app_doctor_show', ['id' => $doctor->getId()]);
        }

        return $this->render('doctor/new.html.twig', [
            'form' => $form,
        ]);
    }
}
