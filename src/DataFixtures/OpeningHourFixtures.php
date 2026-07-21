<?php

namespace App\DataFixtures;

use App\Entity\OpeningHour;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class OpeningHourFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $days = [
            1 => ["09:00", "18:00"],
            2 => ["09:00", "18:00"],
            3 => ["09:00", "18:00"],
            4 => ["09:00", "18:00"],
            5 => ["09:00", "18:00"],
            6 => ["09:00", "12:00"],
            7 => null,
        ];

        foreach ($days as $day => $hours) {
            $openingHour = new OpeningHour();
            $openingHour->setDayOfWeek($day);
            if ($hours !== null) {
                $openingHour->setOpeningTime(new \DateTimeImmutable($hours[0]));
                $openingHour->setClosingTime(new \DateTimeImmutable($hours[1]));
            }
            $manager->persist($openingHour);
        }

        $manager->flush();
    }
}
