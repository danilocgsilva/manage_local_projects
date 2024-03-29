<?php

namespace App\Controller;

use App\Entity\ReceiptFile;
use App\Form\ReceiptFileType\ReceiptFileType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\{Response, Request};
use Doctrine\Persistence\ManagerRegistry as PersistenceManagerRegistry;
use App\Entity\Receipt;

class ReceiptFileController extends AbstractController
{
    #[Route('/receipt_file/{receiptFile}/edit', name: 'app_receipt_file_edit')]
    public function edit(
        ReceiptFile $receiptFile, 
        PersistenceManagerRegistry $doctrine,
        Request $request
    ): Response
    {
        $form = $this->createForm(ReceiptFileType::class, $receiptFile, [
            'label' => 'Update'
        ]);

        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $doctrine->getManager();
            $manager->persist($receiptFile);
            $manager->flush();

            $this->addFlash(
                'success', 
                'Updated receipt file'
            );

            return $this->redirectToRoute('app_receipt_show', [
                'receipt' => $receiptFile->getReceipt()->getId()
            ]);
        }
        
        return $this->render('receipt_file/new_or_edit.html.twig', [
            'form' => $form
        ]);
    }

    #[Route('/receipt_file/{receiptFile}', name: 'app_receipt_file_show')]
    public function show(ReceiptFile $receiptFile): Response
    {
        return $this->render('receipt_file/show.html.twig', [
            'receipt_file' => $receiptFile,
        ]);
    }

    #[Route('/receipt/{receipt}/receipt_file/new', name: 'app_receipt_file_new')]
    public function new(
        Request $request,
        PersistenceManagerRegistry $doctrine,
        Receipt $receipt
    ): Response
    {
        $receiptFile = new ReceiptFile();
        $form = $this->createForm(ReceiptFileType::class, $receiptFile, [
            'label' => 'Add'
        ]);
        $receiptFile->setReceipt($receipt);

        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $doctrine->getManager();
            $manager->persist($receiptFile);
            $manager->flush();

            $this->addFlash(
                'success', 
                'Just added a new receipt file'
            );

            return $this->redirectToRoute('app_receipt_show', [
                'receipt' => $receipt->getId()
            ]);
        }

        return $this->render('receipt_file/new_or_edit.html.twig', [
            'form' => $form
        ]);
    }
}
