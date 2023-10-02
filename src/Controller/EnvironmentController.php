<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Environment;
use App\Form\Path\NewCredentialType;
use App\Form\Path\NewEnvironmentType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\{Response, Request};
use Doctrine\Persistence\ManagerRegistry as PersistenceManagerRegistry;

class EnvironmentController extends AbstractController
{
    #[Route('/environment/new', name: 'app_add_environment')]
    public function new(Request $request,  PersistenceManagerRegistry $doctrine): Response
    {
        $environment = new Environment();
        $form = $this->createForm(NewEnvironmentType::class, $environment);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $doctrine->getManager();
            $manager->persist($environment);
            $manager->flush();

            $this->addFlash('success', 'Environment added');

            return $this->redirectToRoute('app_projects');
        }

        return $this->render('database_credentials/new.html.twig', [
            'form' => $form,
        ]);
    }
}
