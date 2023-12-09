<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Deploy;
use App\Repository\{DeployRepository, EnvironmentRepository, ReceiptRepository};
use App\Form\{
    ConfirmType,
    Deploy\DeployNewType,
    Deploy\DeployEditType
};
use App\Services\FileSystemService;
use Doctrine\Persistence\ManagerRegistry as PersistenceManagerRegistry;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\{Response, Request};
use Symfony\Component\Routing\Annotation\Route;
use Psr\Log\LoggerInterface;
use App\Services\WriteReceiptService;

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

            return $this->redirectToRoute('app_index_deploy');
        }
        
        return $this->render('deploy/new.html.twig', [
            'form' => $form
        ]);
    }

    #[Route('/deploy/index', name: 'app_index_deploy')]
    public function index(DeployRepository $deployRepository)
    {
        return $this->render('deploy/index.html.twig', [
            'deploys' => $deployRepository->findBy([], ['name'=> 'ASC']),
        ]);
    }

    #[Route('/deploy/{deploy}', name: 'app_show_deploy')]
    public function show(Deploy $deploy)
    {
        return $this->render('deploy/show.html.twig', [
            'deploy' => $deploy
        ]);
    }

    #[Route('/deploy/{deploy}/delete', name: 'app_deploy_delete')]
    public function delete(
        PersistenceManagerRegistry $doctrine,
        Deploy $deploy,
        Request $request
    ): Response
    {
        $form = $this->createForm(ConfirmType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $manager = $doctrine->getManager();
            $manager->remove($deploy);
            $manager->flush();

            $this->addFlash(
                'success', 
                'Deploy ' . $deploy->getName() . ' as been deleted.'
            );

            return $this->redirectToRoute('app_index_deploy');
        }

        return $this->render('deploy/delete.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/deploy/{deploy}/edit', name: 'app_deploy_edit')]
    public function edit(
        Request $request,
        Deploy $deploy,
        PersistenceManagerRegistry $doctrine
    ): Response
    {
        $form = $this->createForm(DeployEditType::class, $deploy, [
            'currentFileSystemPathValue' => $deploy->getFileSystemPath()
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $doctrine->getManager();
            $manager->flush();
            $this->addFlash(
               'success',
               'File System Path changed.'
            );
            return $this->redirectToRoute('app_show_deploy', [
                'deploy' => $deploy->getId(),
            ]);
        }
        return $this->render('/deploy/edit.html.twig', [
            'form' => $form
        ]);
    }

    #[Route('/deploy/{deploy}/make', name: 'app_make_deploy')]
    public function makeDeploy(
        Request $request,
        Deploy $deploy,
        FileSystemService $fileSystemService,
        WriteReceiptService $writeReceiptService,
        LoggerInterface $logger
    ): Response
    {
        try {
            
            if ($fileSystemService->createFolder(
                ($fileSystemToWrite = $deploy->getFileSystemPath()),
                $logger
            )) {
                $writeReceiptService->writeReceipt(
                    $fileSystemService,
                    $deploy->getReceipts()->first(),
                    $fileSystemToWrite
                );

                $this->addFlash(
                    'success',
                    'First trial'
                 );
            } else {
                $this->addFlash(
                   'warning',
                   'Folder already exists. Nothing done.'
                );
            }
            
            return $this->redirectToRoute('app_show_deploy', [
                'deploy' => $deploy->getId()
            ]);
        } catch (Exception $e) {
            $this->addFlash(
                'error',
                'Something goes wrong'
            );

            return $this->redirectToRoute('app_show_deploy', [
                'deploy' => $deploy->getId()
            ]);
        }
    }

}
