<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\{Response, Request};
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\EnvironmentFile;
use App\Entity\Environment;
use App\Form\GitAddress\EnvironmentFileType;
use Doctrine\Persistence\ManagerRegistry as PersistenceManagerRegistry;

class EnvironmentFileController extends AbstractController
{
    #[Route('/environment/{environment}/file/new', name: 'app_environment_file_new')]
    public function new(
        Request $request, 
        PersistenceManagerRegistry $doctrine, 
        Environment $environment
    ): Response
    {
        $environmentFile = new EnvironmentFile();
        $form = $this->createForm(EnvironmentFileType::class, $environmentFile);

        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $environmentFile->addEnvironment($environment);
            $manager = $doctrine->getManager();
            $manager->persist($environmentFile);
            $manager->flush();

            $this->addFlash('success', sprintf('Just added a new receipt file to environment'));

            return $this->redirectToRoute('app_show_environment', [
                'environment' => $environment->getId()
            ]);
        }
        
        return $this->render('environment_file/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/environment_file/{environmentFile}', name: 'app_environment_file_show')]
    public function show(EnvironmentFile $environmentFile): Response
    {
        return $this->render('environment_file/show.html.twig', [
            'environmentFile' => $environmentFile
        ]);
    }
}
