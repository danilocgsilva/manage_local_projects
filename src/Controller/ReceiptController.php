<?php

namespace App\Controller;

use App\Form\Receipt\ReceiptType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\{Response, Request};
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry as PersistenceManagerRegistry;
use App\Entity\Environment;
use App\Entity\Receipt;

class ReceiptController extends AbstractController
{
    #[Route('/environment/{environment}/receipt/new', name: 'app_environment_receipt_new')]
    public function new(
        Request $request, 
        PersistenceManagerRegistry $doctrine,
        Environment $environment
    ): Response
    {
        $receipt = new Receipt();
        $receipt->setEnvironment($environment);
        $form = $this->createForm(ReceiptType::class, $receipt);

        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $doctrine->getManager();
            $manager->persist($receipt);
            $manager->flush();

            $this->addFlash('success', sprintf('Just added a new receipt'));

            return $this->redirectToRoute('app_projects');
            /*return $this->redirectToRoute('app_show_environment', [
                'environment' => $environment->getId()
            ]);*/
        }
        
        return $this->render('receipt/new.html.twig', [
            'form' => $form,
        ]);
    }
}
