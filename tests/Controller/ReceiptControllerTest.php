<?php

declare(strict_types=1);

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Entity\Receipt;
use Faker\Factory;

class ReceiptControllerTest extends WebTestCase
{
    public function testIndex(): void
    {
        $client = static::createClient();
        $client->request('GET', '/receipt');

        $this->assertResponseIsSuccessful();
    }

    public function testCreateForm(): void
    {
        $client = static::createClient();
        $client->request('GET', '/receipt/new');

        $this->assertResponseIsSuccessful();
    }

    public function testShow(): void
    {
        $client = static::createClient();
        self::bootKernel();

        $entityManager = static::$kernel->getContainer()
            ->get('doctrine.orm.entity_manager');

        $receipt = $this->getReceiptFromDatabase($entityManager);

        $client->request('GET', '/receipt/' . $receipt->getId());

        $this->assertResponseIsSuccessful();
    }

    public function testEdit(): void
    {
        $client = static::createClient();
        self::bootKernel();

        $entityManager = static::$kernel->getContainer()
            ->get('doctrine.orm.entity_manager');

        $receipt = $this->getReceiptFromDatabase($entityManager);

        $client->request('GET', '/receipt/' . $receipt->getId() . '/edit');

        $this->assertResponseIsSuccessful();
    }

    private function getReceiptFromDatabase($entityManager): Receipt
    {
        $receiptRepository = $entityManager->getRepository(Receipt::class);
        $foundReceipts = $receiptRepository->findAll();
        if (count($foundReceipts)) {
            return $foundReceipts[0];
        }
        $generator = Factory::create();
        $receipt = new Receipt();
        $receipt->setReceipt($generator->name());

        $manager = $entityManager->getManager();
        $manager->persist($receipt);
        $manager->flush();

        return $receipt;
    }
}
