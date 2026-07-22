<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DoctorControllerTest extends WebTestCase
{
    public function testListDoctors(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/doctors');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorExists('.doctor-thumbnail');
    }
}
