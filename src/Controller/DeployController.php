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
use App\Form\Deploy\DeployNewType;

class DeployController extends AbstractController
{
    #[Route('/deploy/new', name: 'app_add_deploy')]
    public function new(
        Request $request, 
        PersistenceManagerRegistry $doctrine,
        EnvironmentRepository $environmentRepository,
        ReceiptRepository $receiptRepository
    ): Response
    {
        $deploy = new Deploy();
        $form = $this->createForm(DeployNewType::class, $deploy, [
            'receipt_list' => $receiptRepository->findBy([], ['receipt' => 'ASC']),
            'environment_list' => $environmentRepository->findBy([], ['name' => 'ASC'])
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $doctrine->getManager();
            $manager->persist($deploy);
            $manager->flush();

            $this->addFlash('success', 'Deploy just created');

            return $this->redirectToRoute('app_projects');
        }
        
        return $this->render('deploy/new.html.twig', [
            'form' => $form
        ]);
    }
}