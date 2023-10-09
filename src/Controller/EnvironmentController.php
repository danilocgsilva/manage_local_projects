<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Environment;
use App\Form\Path\NewEnvironmentType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\{Response, Request};
use Doctrine\Persistence\ManagerRegistry as PersistenceManagerRegistry;
use App\Repository\EnvironmentRepository;
use Symfony\Component\DependencyInjection\ContainerInterface;
use App\Services\Environment as EnvironmentService;

class EnvironmentController extends AbstractController
{
    #[Route('/environments', name: 'app_environments')]
    public function index(EnvironmentRepository $environmentRepository)
    {
        return $this->render('environments/index.html.twig', [
            'environments' =>
                $environmentRepository->findBy([], ['name' => 'ASC'])
        ]);
    }

    #[Route('/environments/new', name: 'app_add_environment')]
    public function new(Request $request, PersistenceManagerRegistry $doctrine): Response
    {
        $environment = new Environment();
        $form = $this->createForm(NewEnvironmentType::class, $environment);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $doctrine->getManager();
            $manager->persist($environment);
            $manager->flush();

            $this->addFlash('success', 'Environment added');

            return $this->redirectToRoute('app_environments');
        }

        return $this->render('environments/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/environments/{environment}', name: 'app_show_environment')]
    public function show(Environment $environment): Response
    {
        return $this->render('environments/show.html.twig', [
            'environment' => $environment
        ]);
    }

    #[Route('/environments/{environment}/fingerprint', name: 'app_environment_fingerprint')]
    public function finterprint(
        Environment $environment,
        EnvironmentService $environmentService,
        PersistenceManagerRegistry $doctrine
    ) {
        $environment
            ->setUnameNFingerprint($environmentService->getUnameN())
            ->setUnameAFingerprint($environmentService->getUnameA());

        $manager = $doctrine->getManager();
        $manager->persist($environment);
        $manager->flush();

        return $this->redirectToRoute(
            'app_show_environment', 
            ['environment' => $environment->getId()]
        );
    }
}