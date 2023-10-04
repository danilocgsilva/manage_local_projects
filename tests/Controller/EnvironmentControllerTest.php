<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class EnvironmentControllerTest extends WebTestCase
{
    public function testEnvironmentsRouteBasic(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/environments');

        $this->assertResponseIsSuccessful();
    }

    public function testCreateRouteBasic(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/environment/new');

        $this->assertResponseIsSuccessful();
    }
}
