<?php

namespace App\Controller;

use App\Repository\OpeningHourRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

final class OpeningHourController extends AbstractController
{
    public function displayCalendar(OpeningHourRepository $openingHourRepository): Response
    {
        return $this->render('opening_hour/_calendar.html.twig', [
            'openingHours' => $openingHourRepository->findBy([], ['dayOfWeek' => 'ASC']),
            'currentWeekday' => date('N'),
        ]);
    }
}
