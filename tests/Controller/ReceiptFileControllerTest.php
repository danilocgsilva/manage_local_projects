<?php

declare(strict_types=1);

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Entity\ReceiptFile;
use App\Entity\Receipt;
use Faker\Factory;

class ReceiptFileControllerTest extends WebTestCase
{
    public function testShow(): void
    {
        $client = static::createClient();
        self::bootKernel();

        $entityManager = static::$kernel->getContainer()
            ->get('doctrine.orm.entity_manager');

        $receiptFile = $this->fetchReceiptFileFromDatabase($entityManager);

        $client->request('GET', '/receipt_file/' . $receiptFile->getId());

        $this->assertResponseIsSuccessful();
    }

    private function fetchReceiptFileFromDatabase($entityManager): ReceiptFile
    {
        $receiptFileRepository = $entityManager->getRepository(ReceiptFile::class);
        $foundReceiptsFiles = $receiptFileRepository->findAll();
        if (count($foundReceiptsFiles)) {
            return $foundReceiptsFiles[0];
        }
        $generator = Factory::create();
        $receiptFile = (new ReceiptFile())
            ->setPath($generator->name())
            ->setContent($generator->name());

        $receipt = (new Receipt())
            ->setReceipt($generator->name());
            
        $receiptFile->setReceipt($receipt);
            
        $entityManager->persist($receipt);
        $entityManager->persist($receiptFile);
        $entityManager->flush();
        
        return $receiptFile;
    }
}
