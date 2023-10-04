<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProjectsControllerTest extends WebTestCase
{
    public function testProjectsRouteBasic(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/projects');

        $this->assertResponseIsSuccessful();
    }

    public function testProjectNewRouteBasic(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/projects/new');

        $this->assertResponseIsSuccessful();
    }
}
