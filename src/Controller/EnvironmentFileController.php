<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EnvironmentFileController extends AbstractController
{
    #[Route('/environment/{environment}/file/new', name: 'app_environment_file_new')]
    public function new(
        Request $request, 
        PersistenceManagerRegistry $doctrine,
        Environment $environment
    ): Response
    {
        // $receipt = new Receipt();
        // $receipt->setEnvironment($environment);
        // $form = $this->createForm(ReceiptType::class, $receipt);

        // $form->handleRequest($request);
        
        // if ($form->isSubmitted() && $form->isValid()) {
        //     $manager = $doctrine->getManager();
        //     $manager->persist($receipt);
        //     $manager->flush();

        //     $this->addFlash('success', sprintf('Just added a new receipt'));

        //     return $this->redirectToRoute('app_projects');
        //     /*return $this->redirectToRoute('app_show_environment', [
        //         'environment' => $environment->getId()
        //     ]);*/
        // }
        
        return $this->render('environment_file/new.html.twig', [
            'form' => $form,
        ]);
    }
}
