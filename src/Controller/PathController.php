<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Project;
use App\Form\Path\PathType;
use Symfony\Component\HttpFoundation\{Response, Request};
use Doctrine\Persistence\ManagerRegistry as PersistenceManagerRegistry;

class PathController extends AbstractController
{
    #[Route('/project/{project}/path/new', name: 'app_project_path_new')]
    public function new(
        Project $project, 
        Request $request, 
        PersistenceManagerRegistry $doctrine
    ): Response
    {
        $form = $this->createForm(PathType::class, $project, [
            'project_name' => $project->getName()
        ]);

        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {

            dd($form);

            $manager = $doctrine->getManager();
            $project->setPath("Abc123");
            $manager->persist($project);
            $manager->flush();

            return $this->redirectToRoute(
                'app_projects_show',
                [
                    'project' => $project->getId()
                ]
            );
        }

        return $this->render('path/new.html.twig', [
            'project' => $project,
            'form' => $form,
        ]);
    }
}
