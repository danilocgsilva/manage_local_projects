<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Deploy;
use Doctrine\Persistence\ManagerRegistry as PersistenceManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\{Response, Request};
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\EnvironmentRepository;
use App\Repository\ReceiptRepository;

class DeployController extends AbstractController
{
    #[Route('/deploy/new', name: 'app_add_deploy')]
    public function new(
        Request $request, 
        PersistenceManagerRegistry $doctrine
        //EnvironmentRepository $environmentRepository,
        //ReceiptRepository $receiptRepository
    ): Response
    {
        $deploy = new Deploy();
        $form = $this->createForm(DeployNewType::class, $deploy);
        
        return $this->render('deploy/new.html.twig', [
            // 'environments' => $environmentRepository->findBy([], ['name' => 'ASC']),
            // 'receipts' => $receiptRepository->findBy([], ['receipt' => 'ASC'])
            'form' => $form
        ]);
    }
}