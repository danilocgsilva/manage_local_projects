<?php

declare(strict_types=1);

namespace App\Controller;

use App\Form\DatabaseCredentials\NewCredentialType;
use App\Repository\DatabaseCredentialsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\{Response, Request};
use App\Entity\DatabaseCredentials;
use Doctrine\Persistence\ManagerRegistry as PersistenceManagerRegistry;
use App\Services\EncryptionService;

class DatabaseCredentialsController extends AbstractController
{
    #[Route('/database_credentials/new', name: 'app_add_database_credentials')]
    public function new(
        Request $request, 
        PersistenceManagerRegistry $doctrine,
        EncryptionService $encryptionService
    ): Response
    {
        $databaseCredential = new DatabaseCredentials();
        $form = $this->createForm(NewCredentialType::class, $databaseCredential);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $databaseCredential->setPassword(
                $encryptionService->encryptData(
                    $databaseCredential->getPassword()
                )
            );
            
            $manager = $doctrine->getManager();
            $manager->persist($databaseCredential);
            $manager->flush();

            $this->addFlash('success', 'Database credentials has been successfully registered!');

            return $this->redirectToRoute('app_show_database_credentials', ['database_credentials' => $databaseCredential->getId() ]);
        }

        return $this->render('database_credentials/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/database_credentials', name: 'app_index_database_credentials')]
    public function index(DatabaseCredentialsRepository $databaseCredentialsRepository): Response
    {
        return $this->render('database_credentials/index.html.twig', [
            'database_credentials' =>
                $databaseCredentialsRepository->findBy([], ['host' => 'ASC'])
        ]);
    }

    #[Route('/database_credentials/{database_credentials}', name: 'app_show_database_credentials')]
    public function show(DatabaseCredentials $database_credentials): Response
    {
        return $this->render('database_credentials/show.html.twig', [
            'database_credentials' => $database_credentials
        ]);
    }
}
