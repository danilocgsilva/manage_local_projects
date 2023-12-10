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
use App\Entity\ReceiptFile;
use Exception;

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
                'Updated receipt'
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
        $receiptFiles = array_map(fn ($entry) => $entry, $receipt->getReceiptFiles()->toArray());
        if (count($receiptFiles) === 0) {
            $this->addFlash(
                'success',
                'No files from receipt.',
            );
            return $this->redirectToRoute('app_receipt_show', ['receipt' => $receipt->getId()]);
        }
        
        $zipName = $receipt->getReceipt() . ".zip";
        $zipNamePath = sys_get_temp_dir() . DIRECTORY_SEPARATOR . $zipName;
        $zip = new ZipArchive();
        if ($zip->open($zipNamePath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {
            foreach ($receiptFiles as $file) {
                $zip->addFromString($file->getPath(), $file->getContent());
            }
    
            $zip->close();
    
            return $this->file($zipNamePath);
        } else {
            throw new Exception("The file zip could not be created.");
        }
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
            $filePath = $form->getData()['file_path'];

            $returnInError = function($receipt, $form, string $errorMessage) {
                $this->addFlash(
                    'error', 
                    $errorMessage
                );
                
                return $this->redirectToRoute(
                    'app_receipt_capture_file', 
                    [
                        'receipt' => $receipt->getId(),
                        'path_provided' => $form->getData()['file_path']
                    ]
                );
            };

            if (!file_exists($filePath)) {               
                return $returnInError(
                    $receipt, 
                    $form,
                    'The provided path does not exists or ths system does not have permission to reach it!'
                );
            }

            if (!($fileResource = fopen($filePath, "r"))) {
                return $returnInError(
                    $receipt, 
                    $form,
                    'The file exists, but is not readable.'
                );
            }
            
            $fileContent = fread($fileResource, filesize($filePath));
            fclose($fileResource);

            $receiptFile = (new ReceiptFile())
                ->setPath(
                    $filePath
                )->setContent(
                    $fileContent
                );

            $manager = $doctrine->getManager();

            $manager->persist($receiptFile);
            
            $receipt->addReceiptFile($receiptFile);
            $manager->persist($receipt);
            $manager->flush();

            $this->addFlash(
                'success', 
                'Receipt file just added to the receipt.'
            );

            return $this->redirectToRoute('app_receipt_index');
        }
        
        return $this->render('receipt/capture.html.twig', [
            'form' => $form
        ]);
    }
}
