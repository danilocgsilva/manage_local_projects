<?php

namespace App\Controller;

use App\Form\Receipt\ReceiptType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\{Response, Request};
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry as PersistenceManagerRegistry;
use App\Entity\Project;
use App\Entity\Receipt;
use App\Form\Receipt\RemoveReceiptType;

class ReceiptController extends AbstractController
{
    #[Route('/project/{project}/receipt/new', name: 'app_project_receipt_new')]
    public function new(
        Request $request, 
        PersistenceManagerRegistry $doctrine,
        Project $project
    ): Response
    {
        $receipt = new Receipt();
        $receipt->setProject($project);
        $form = $this->createForm(ReceiptType::class, $receipt);

        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $doctrine->getManager();
            $manager->persist($receipt);
            $manager->flush();

            $this->addFlash(
                'success', 
                sprintf(
                    'Just added a new receipt for project %s: %s', 
                    $project->getName(),
                    $receipt->getReceipt()
                )
            );

            return $this->redirectToRoute('app_projects_show', [
                'project' => $project->getId()
            ]);
        }
        
        return $this->render('receipt/new_or_edit.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/receipt/{receipt}/edit', name: 'app_receipt_edit')]
    public function edit(
        Request $request,
        Receipt $receipt,
        PersistenceManagerRegistry $doctrine
    ): Response
    {
        $form = $this->createForm(ReceiptType::class, $receipt);

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
        $form = $this->createForm(RemoveReceiptType::class);

        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $doctrine->getManager();
            $receiptName = $receipt->getReceipt();
            $project = $receipt->getProject();
            $manager->remove($receipt);
            $manager->flush();

            $this->addFlash(
                'success', 
                sprintf(
                    'Removed %s receipt from project %s', 
                    $receiptName,
                    $project->getName()
                )
            );

            return $this->redirectToRoute('app_projects_show', [
                'project' => $project->getId()
            ]);
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


}
