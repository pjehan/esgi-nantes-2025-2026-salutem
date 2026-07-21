<?php

namespace App\Controller;

use App\Entity\Doctor;
use App\Repository\DoctorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

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

    #[Route('/doctor/{id}', name: 'app_doctor_show')]
    public function show(Doctor $doctor): Response
    {
        return $this->render('doctor/show.html.twig', [
            'doctor' => $doctor,
        ]);
    }
}
