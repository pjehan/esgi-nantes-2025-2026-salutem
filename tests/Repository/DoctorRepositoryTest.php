<?php

namespace App\Tests\Repository;

use App\Entity\Doctor;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class DoctorRepositoryTest extends KernelTestCase
{
    private ?EntityManagerInterface $entityManager;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();
        $this->entityManager = $kernel->getContainer()->get('doctrine')->getManager();
    }

    public function testFindDoctorWithSpecialties(): void
    {
        $doctors = $this->entityManager->getRepository(Doctor::class)->findDoctorsWithSpecialties();
        // Check if the doctor specialties are already loaded
        $specialties = $doctors[0]->getSpecialties();
        $this->assertTrue($specialties->isInitialized());
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        // doing this is recommended to avoid memory leaks
        $this->entityManager->close();
        $this->entityManager = null;
    }
}
