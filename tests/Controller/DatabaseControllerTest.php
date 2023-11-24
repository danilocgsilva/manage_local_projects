<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Entity\DatabaseCredentials;
use Faker\Factory;

class DatabaseControllerTest extends WebTestCase
{
    public function testEnvironmentsRouteBasic(): void
    {
        $client = static::createClient();
        $client->request('GET', '/database_credentials');

        $this->assertResponseIsSuccessful();
    }

    public function testEnvironmentsRouteNew(): void
    {
        $client = static::createClient();
        $client->request('GET', '/database_credentials/new');

        $this->assertResponseIsSuccessful();
    }
}