<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\{Response, Request};
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\{SubmitType, TextType};
use App\Entity\Project;
use App\Form\ProjectType;
use App\Repository\ProjectRepository;
use Doctrine\Persistence\ManagerRegistry as PersistenceManagerRegistry;

class ProjectsController extends AbstractController
{
    #[Route('/projects', name: 'app_projects')]
    public function index(ProjectRepository $projectRepository): Response
    {
        return $this->render('projects/index.html.twig', [
            'projects' => 
                $projectRepository->findBy([], ['name' => 'ASC'])
        ]);
    }

    #[Route('/projects/new', name: 'app_projects_new')]
    public function new(Request $request, PersistenceManagerRegistry $doctrine): Response
    {
        $project = new Project();
        $form = $this->createForm(ProjectType::class, $project);

        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $doctrine->getManager();
            $manager->persist($project);
            $manager->flush();

            return $this->redirectToRoute('app_projects');
        }
        
        return $this->render('projects/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/projects/{project}', name: 'app_projects_show')]
    public function show(Project $project): Response
    {
        return $this->render('projects/show.html.twig', [
            'project' => $project
        ]);
    }

    #[Route('/projects/{project}/delete', name: 'app_projects_delete_confirmation', methods: ['GET'])]
    public function deleteConfirm(Project $project): Response
    {
        return $this->render('projects/delete.html.twig', [
            'project' => $project
        ]);
    }

    // #[Route('/projects/{project}/delete', name: 'app_projects_delete', methods: ['DELETE'])]
    // public function controllerAction(Request request): Response
    // {
    //     return $this->redirectToRoute('app_projects');
    // }
}
