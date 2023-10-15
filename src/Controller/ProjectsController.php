<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\{Response, Request};
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Project;
use App\Form\Project\ProjectType;
use App\Repository\ProjectRepository;
use Doctrine\Persistence\ManagerRegistry as PersistenceManagerRegistry;
use App\Form\Project\DeleteProjectType;
use App\Entity\Environment;
use App\Form\Path\NewEnvironmentType;
use App\Entity\GitAddress;
use App\Form\GitAddress\GitAddressType;

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

            $this->addFlash('success', sprintf('The project %s has been successfully registered!', $project->getName()));

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

    #[Route('/projects/{project}/gitaddress/new', name: 'app_project_add_gitaddress')]
    public function newGitAddress(
        Project $project,
        PersistenceManagerRegistry $doctrine,
        Request $request
    ): Response
    {
        $gitaddress = new GitAddress();
        $gitaddress->setProject($project);

        $form = $this->createForm(GitAddressType::class, $gitaddress, [
            'project_name' => $project->getName()
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $doctrine->getManager();
            $manager->persist($gitaddress);
            $manager->flush();

            $this->addFlash('success', sprintf("Remote git address added to project %s", $project->getName()));

            return $this->redirectToRoute('app_projects_show', ['project' => $project->getId()]);
        }

        return $this->render('projects/newGitAddress.html.twig', [
            'form' => $form,
            'project' => $project
        ]);
    }

    #[Route('/projects/{project}/environment/new', name: 'app_project_add_environment')]
    public function newEnvironment(
        Project $project, 
        Request $request,
        PersistenceManagerRegistry $doctrine
    ): Response
    {
        $environment = new Environment();
        $environment->addProject($project);
        $form = $this->createForm(NewEnvironmentType::class, $environment);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $doctrine->getManager();
            $manager->persist($environment);
            $manager->flush();

            $this->addFlash('success', sprintf("Environment added to project %s", $project->getName()));

            return $this->redirectToRoute('app_projects_show', ['project' => $project->getId()]);
        }

        return $this->render('projects/newEnvironment.html.twig', [
            'form' => $form,
            'project' => $project
        ]);
    }

    #[Route('/projects/{project}/delete', name: 'app_projects_delete_confirmation')]
    public function delete(
        Request $request, 
        Project $project, 
        PersistenceManagerRegistry $doctrine
    ): Response
    {
        $form = $this->createForm(DeleteProjectType::class, $project);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $doctrine->getManager();
            $manager->remove($project);
            $manager->flush();

            $this->addFlash(
                'success', 
                sprintf(
                    'The project %s has been deleted!!', $project->getName()
                )
            );

            return $this->redirectToRoute(
                'app_projects'
            );
        }
        
        return $this->render('projects/delete.html.twig', [
            'project' => $project,
            'form' => $form,
        ]);
    }
}
