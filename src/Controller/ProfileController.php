<?php

namespace App\Controller;

use App\Repository\AppointmentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

final class ProfileController extends AbstractController
{
    #[Route('/profile', name: 'app_profile')]
    public function index(#[CurrentUser] $user, AppointmentRepository $appointmentRepository): Response
    {
        $appointments = $appointmentRepository->findBy(['user' => $user], ['date' => 'DESC']);
        return $this->render('profile/index.html.twig', [
            'appointments' => $appointments,
        ]);
    }
}
