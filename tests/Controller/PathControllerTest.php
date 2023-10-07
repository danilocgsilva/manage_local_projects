<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PathControllerTest extends WebTestCase
{
    public function testProjectsRouteBasic(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/projects');

        $this->assertResponseIsSuccessful();
    }
}
