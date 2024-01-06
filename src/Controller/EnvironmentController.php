<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Environment;
use App\Form\Environment\{BindDatabaseCredentialType, EnvironmentType};
use App\Repository\EnvironmentRepository;
use App\Services\Environment as EnvironmentService;
use Doctrine\Persistence\ManagerRegistry as PersistenceManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\{Response, Request};
use Symfony\Component\Routing\Annotation\Route;
use App\Form\ConfirmType;
use App\Repository\DatabaseCredentialsRepository;

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
    public function new(
        Request $request, 
        PersistenceManagerRegistry $doctrine
    ): Response
    {
        $environment = new Environment();
        $form = $this->createForm(EnvironmentType::class, $environment, [
            'submit_label' => 'Add environment'
        ]);

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

    #[Route('/environment/{environment}/edit', name: 'app_environment_edit')]
    public function edit(
        Request $request,
        Environment $environment,
        PersistenceManagerRegistry $doctrine
    ): Response
    {
        $form = $this->createForm(EnvironmentType::class, $environment, [
            'submit_label' => 'Alter environment'
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $doctrine->getManager();
            $manager->persist($environment);
            $manager->flush();

            $this->addFlash(
                'success',
                'Updated environment',
            );

            return $this->redirectToRoute('app_show_environment', [
                'environment' => $environment->getId()
            ]);
        }

        return $this->render('environments/edit.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/environment/{environment}/delete', name: 'app_environment_delete')]
    public function delete(
        Request $request,
        PersistenceManagerRegistry $doctrine,
        Environment $environment
    ): Response
    {
        $form = $this->createForm(ConfirmType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $environmentName = $environment->getName();
            $manager = $doctrine->getManager();
            $manager->remove($environment);
            $manager->flush();

            $this->addFlash(
                'success',
                sprintf(
                    'The environment %s has been deleted!',
                    $environmentName
                )
            );

            return $this->redirectToRoute('app_environments');
        }

        return $this->render('environments/remove.html.twig', [
            'form' => $form,
            'environment' => $environment
        ]);
    }

    #[Route('/environments/{environment}/bind_database_credential', name: 'app_environment_bind_database_credential')]
    public function bindDatabaseCredential(
        Request $request,
        PersistenceManagerRegistry $doctrine,
        Environment $environment,
        DatabaseCredentialsRepository $databaseCredentialsRepository
    ): Response
    {
        $form = $this->createForm(BindDatabaseCredentialType::class, $environment, [
            'database_credential_list' => $databaseCredentialsRepository->findBy([], ['name' => 'ASC'])
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $doctrine->getManager();
            $manager->persist($environment);
            $manager->flush();
            
            $this->addFlash('success', 'Bind done');

            return $this->redirectToRoute('app_show_environment', [
                'environment' => $environment->getId()
            ]);
        }
        
        return $this->render('environments/bind_database_credential.html.twig', [
            'form' => $form
        ]);
    }

    /**
     * @Route("/environments/{environment}/disableXDebug", name="app_environment_disable_x_debug")
     */
    public function disableXDebug(Environment $environment): Response
    {
        return $this->redirectToRoute('app_show_environment', [
            'environment' => $environment->getId()
        ]);
    }
}
