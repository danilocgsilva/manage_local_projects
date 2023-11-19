<?php

namespace App\Controller;

use App\Entity\Receipt;
use App\Form\Receipt\{RemoveReceiptType, CaptureFileType, ReceiptType};
use App\Repository\ReceiptRepository;
use Doctrine\Persistence\ManagerRegistry as PersistenceManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\{Response, Request};
use Symfony\Component\Routing\Annotation\Route;
use ZipArchive;

class ReceiptController extends AbstractController
{
    #[Route('/receipt', name: 'app_receipt_index')]
    public function index(ReceiptRepository $receiptRepository): Response
    {
        return $this->render('receipt/index.html.twig', [
            'receipts' => $receiptRepository->findBy([], ['receipt' => 'ASC'])
        ]);
    }

    #[Route('/receipt/new', name: 'app_add_receipt')]
    public function new(Request $request, PersistenceManagerRegistry $doctrine): Response
    {
        $receipt = new Receipt();
        $form = $this->createForm(ReceiptType::class, $receipt, [
            'label' => 'Create'
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $doctrine->getManager();
            $manager->persist($receipt);
            $manager->flush();

            $this->addFlash(
                'success',
                'Created new receipt',
            );

            return $this->redirectToRoute('app_receipt_index');
        }

        return $this->render('receipt/new_or_edit.html.twig', [
            'form' => $form
        ]);
    }

    #[Route('/receipt/{receipt}/edit', name: 'app_receipt_edit')]
    public function edit(
        Request $request,
        Receipt $receipt,
        PersistenceManagerRegistry $doctrine
    ): Response
    {
        $form = $this->createForm(ReceiptType::class, $receipt, [
            'label' => 'Change'
        ]);

        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $doctrine->getManager();
            $manager->persist($receipt);
            $manager->flush();

            $this->addFlash(
                'success',
                'Updated receipt',
            );

            return $this->redirectToRoute('app_receipt_show', [
                'receipt' => $receipt->getId()
            ]);
        }

        return $this->render('receipt/new_or_edit.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/receipt/{receipt}', name: 'app_receipt_show')]
    public function show(Receipt $receipt): Response
    {
        return $this->render('receipt/show.html.twig', [
            'receipt' => $receipt
        ]);
    }

    #[Route('/receipt/{receipt}/delete', name: 'app_receipt_delete')]
    public function delete(
        Request $request, 
        PersistenceManagerRegistry $doctrine,
        Receipt $receipt
    ): Response
    {
        $form = $this->createForm(RemoveReceiptType::class, null, [
            'label' => 'Custom label'
        ]);

        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $doctrine->getManager();
            $receiptName = $receipt->getReceipt();
            $projectsString = implode(
                ',', 
                array_map(
                    fn ($entry) => $entry->getName()
                    , $receipt->getProjects()->toArray()
                )
            );
            $manager->remove($receipt);
            $manager->flush();

            $this->addFlash(
                'success', 
                sprintf(
                    'Removed %s receipt from project %s', 
                    $receiptName,
                    $projectsString
                )
            );

            return $this->redirectToRoute('app_receipt_index');
        }

        $this->addFlash(
            'danger', 
            'Caution: this action is undonable!'
        );
        
        return $this->render('receipt/remove.html.twig', [
            'form' => $form,
            'receipt' => $receipt
        ]);
    }

    #[Route('/receipt/{receipt}/download', name: 'app_receipt_download')]
    public function download(
        Request $request, 
        PersistenceManagerRegistry $doctrine,
        Receipt $receipt
    ): Response
    {
        $zipName = $receipt->getReceipt() . ".zip";
        $zipNamePath = sys_get_temp_dir() . DIRECTORY_SEPARATOR . $zipName;
        $zip = new ZipArchive();
        $zip->open($zipNamePath, ZipArchive::CREATE | ZipArchive::OVERWRITE);

        foreach ($receipt->getReceiptFiles() as $file) {
            $zip->addFromString($file->getPath(), $file->getContent());
        }

        $zip->close();

        return $this->file($zipNamePath);
    }

    #[Route('/receipt/{receipt}/capture', name: 'app_receipt_capture_file')]
    public function captureFile(
        Request $request,
        PersistenceManagerRegistry $doctrine,
        Receipt $receipt
    ): Response
    {
        $form = $this->createForm(CaptureFileType::class, null, [
            'path_data' => $request->query->get('path_provided')
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $doctrine->getManager();

            $filePath = $form->getData()['file_path'];

            if (!file_exists($filePath)) {

                $this->addFlash(
                    'error', 
                    'The provided path does not exists!'
                );
                
                return $this->redirectToRoute(
                    'app_receipt_capture_file', 
                    [
                        'receipt' => $receipt->getId(),
                        'path_provided' => $form->getData()['file_path']
                    ]
                );
            }
            
            /*
            $receiptName = $receipt->getReceipt();
            $projectsString = implode(
                ',', 
                array_map(
                    fn ($entry) => $entry->getName()
                    , $receipt->getProjects()->toArray()
                )
            );
            $manager->remove($receipt);
            $manager->flush();

            $this->addFlash(
                'success', 
                sprintf(
                    'Removed %s receipt from project %s', 
                    $receiptName,
                    $projectsString
                )
            );
            */

            return $this->redirectToRoute('app_receipt_index');
        }
        
        return $this->render('receipt/capture.html.twig', [
            'form' => $form
        ]);
    }
}
