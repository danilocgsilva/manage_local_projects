<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Entity\Environment;
use Faker\Factory;

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
        $crawler = $client->request('GET', '/environments/new');

        $this->assertResponseIsSuccessful();
    }

    public function testEdit(): void
    {
        $client = static::createClient();
        self::bootKernel();

        $entityManager = static::$kernel->getContainer()
            ->get('doctrine.orm.entity_manager');

        $environment = $this->getEnvironmentFromDatabase($entityManager);
        
        $client->request('GET', '/environment/' . $environment->getId() . '/edit');

        $this->assertResponseIsSuccessful();
    }

    public function testShow(): void
    {
        $client = static::createClient();
        self::bootKernel();

        $entityManager = static::$kernel->getContainer()
            ->get('doctrine.orm.entity_manager');

        $environment = $this->getEnvironmentFromDatabase($entityManager);
        
        $client->request('GET', '/environments/' . $environment->getId());

        $this->assertResponseIsSuccessful();
    }

    public function getEnvironmentFromDatabase($entityManager): Environment
    {
        $receiptRepository = $entityManager->getRepository(Environment::class);
        $foundReceipts = $receiptRepository->findAll();
        if (count($foundReceipts)) {
            return $foundReceipts[0];
        }
        $generator = Factory::create();
        $environment = new Environment();
        $environment->setName($generator->name());

        $manager = $entityManager->getManager();
        
        $manager->persist($environment);
        $manager->flush();

        return $environment;
    }
}
