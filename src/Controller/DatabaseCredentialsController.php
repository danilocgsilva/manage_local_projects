<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\DatabaseCredentials;
use App\Form\DatabaseCredentials\NewCredentialType;
use App\Form\DeleteType;
use App\Services\EncryptionService;
use App\Repository\DatabaseCredentialsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\{Response, Request};
use Doctrine\Persistence\ManagerRegistry as PersistenceManagerRegistry;

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
    public function show(DatabaseCredentials $database_credentials, EncryptionService $encryptionService): Response
    {
        $database_credentials->setPassword(
            $encryptionService->decryptData($database_credentials->getPassword())
        );
        
        return $this->render('database_credentials/show.html.twig', [
            'database_credentials' => $database_credentials
        ]);
    }

    #[Route('/database_credentials/{databaseCredentials}/delete', name: 'app_delete_database_credentials')]
    public function delete(
        Request $request, 
        DatabaseCredentials $databaseCredentials, 
        PersistenceManagerRegistry $doctrine
    ): Response
    {
        $form = $this->createForm(DeleteType::class, $databaseCredentials);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $doctrine->getManager();
            $manager->remove($databaseCredentials);
            $manager->flush();

            $this->addFlash(
                'success', 
                'Database credential deleted!'
            );

            return $this->redirectToRoute(
                'app_index_database_credentials'
            );
        }
        
        return $this->render('database_credentials/delete.html.twig', [
            'database_credential' => $databaseCredentials,
            'form' => $form,
        ]);
    }
}
