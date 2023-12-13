<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\EnvironmentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\{Response, Request};
use Symfony\Component\Routing\Annotation\Route;
use App\Form\Project\ProjectType;
use App\Repository\ProjectRepository;
use Doctrine\Persistence\ManagerRegistry as PersistenceManagerRegistry;
use App\Entity\{GitAddress, Receipt, Environment, Deploy, Project};
use App\Form\{
    ConfirmType,
    GitAddress\GitAddressType,
    Receipt\ReceiptType,
    Project\ReceiptListType,
    Project\BindEnvironmentType,
    Environment\EnvironmentType
};
use App\Enums\ProjectType as EnumProjectType;
use Exception;
use App\Repository\ReceiptRepository;
use App\Form\Deploy\DeployNewType;

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

            return $this->redirectToRoute('app_projects_show', [
                'project' => $project->getId()
            ]);
        }
        
        return $this->render('projects/new.html.twig', [
            'form' => $form,
        ]);
    }
 
    #[Route('/projects/{project}', name: 'app_projects_show')]
    public function show(Project $project): Response
    {
        $view = "";

        switch ($project->getType()) {
            case EnumProjectType::Normal->name:
                $view = 'projects/show.html.twig';
                break;
            case EnumProjectType::Database->name:
                $view = 'projects/database/show.html.twig';
                break;
            default:
                throw new Exception("Project type is not recognizable.");
        }
        
        return $this->render($view, [
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

    #[Route('/projects/{project}/gitaddress/remove', name: 'app_project_remove_gitaddress')]
    public function removeGitRemoteAddress(
        Project $project,
        PersistenceManagerRegistry $doctrine,
        Request $request
    ): Response
    {
        $manager = $doctrine->getManager();

        return $this->redirectToRoute('app_projects_show', [
            'project' => $project->getId()
        ]);
    }

    /*
    public function removeEnvironment(Environment $environment): static
    {
        $this->environment->removeElement($environment);

        return $this;
    }*/

    #[Route('/projects/{project}/environment/new', name: 'app_project_add_environment')]
    public function newEnvironment(
        Project $project, 
        Request $request,
        PersistenceManagerRegistry $doctrine
    ): Response
    {
        $environment = new Environment();
        $environment->addProject($project);
        $form = $this->createForm(EnvironmentType::class, $environment, [
            'submit_label' => "Add environment"
        ]);

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
        $form = $this->createForm(ConfirmType::class, $project);

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

    #[Route('/project/{project}/receipt/new', name: 'app_project_receipt_new')]
    public function newProjectReceipt(
        Request $request, 
        PersistenceManagerRegistry $doctrine,
        Project $project
    ): Response
    {
        $receipt = new Receipt();
        $receipt->addProject($project);
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

    #[Route('/project/{project}/bind', name: 'app_project_bind_receipt')]
    public function bind(
        Request $request, 
        PersistenceManagerRegistry $doctrine,
        Project $project, 
        ReceiptRepository $receiptRepository
    ): Response
    {
        $form = $this->createForm(ReceiptListType::class, null, [
            'receipt_list' => $receiptRepository->getReceiptsAsArray(),
            'label' => 'Bind a receipt to project ' . $project->getName()
        ]);

        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $receiptChoosen = $receiptRepository->find(
                $receiptRepository->find(
                    $form->getData()->getReceipt()
                )
            );
            $project->addReceipt($receiptChoosen);

            $manager = $doctrine->getManager();
            $manager->persist($project);
            $manager->flush();

            $this->addFlash(
                'success', 
                'The receipt has been binded to the project'
            );

            return $this->redirectToRoute('app_projects_show', [
                'project' => $project->getId()
            ]);
        }
        
        return $this->render('projects/bindReceipt.html.twig', [
            'form' => $form
        ]);
    }

    #[Route('/project/{project}/unbind/{receipt}', name: 'app_project_unbind_receipt')]
    public function unbind(
        Project $project, 
        Receipt $receipt,
        Request $request,
        PersistenceManagerRegistry $doctrine,
    ): Response
    {
        $form = $this->createForm(ConfirmType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $project->removeReceipt($receipt);

            $manager = $doctrine->getManager();
            $manager->persist($project);
            $manager->flush();

            $this->addFlash(
                'success', 
                'Unbind succeeded'
            );

            return $this->redirectToRoute('app_projects_show', [
                'project' => $project->getId()
            ]);
        }
        
        return $this->render('projects/unbindReceipt.html.twig', [
            'project' => $project,
            'receipt' => $receipt,
            'form' => $form
        ]);
    }

    #[Route('/project/{project}/deploy/new', name: 'app_project_create_deploy')]
    public function createDeploy(
        ReceiptRepository $receiptRepository,
        EnvironmentRepository $environmentRepository,
        Project $project,
        Request $request, 
        PersistenceManagerRegistry $doctrine,
    ): Response 
    {
        if (
            count(
                ($receiptList = $receiptRepository->findBy([], ['receipt' => 'ASC']))
            ) === 0
            ||
            count(
                ($environmentList = $environmentRepository->findBy([], ['name' => 'ASC']))
            ) === 0
        ) {
            $this->addFlash('error', 'We need to have at least one environment and at least one receipt registered to allow a deployment creation.');
            return $this->redirectToRoute('app_projects_show', ['project' => $project->getId()]);
        }
        
        $deploy = new Deploy();
        $form = $this->createForm(DeployNewType::class, $deploy, [
            'receipt_list' => $receiptList,
            'environment_list' => $environmentList,
            'default_deploy_name' => $project->getName() . " Deploy"
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $doctrine->getManager();
            $deploy->setProject($project);
            $manager->persist($deploy);
            $manager->flush();

            $this->addFlash('success', 'Deploy just created for project ' . $project->getName());

            return $this->redirectToRoute('app_projects_show', ['project' => $project->getId()]);
        }

        return $this->render('deploy/new.html.twig', [
            'form' => $form,
            'project' => $project
        ]);
    }

    #[Route('/project/{project}/environment/unbind/{environment}', name: 'app_project_unbind_environment')]
    public function unbindEnvironment(
        Request $request,
        Environment $environment,
        Project $project,
        PersistenceManagerRegistry $doctrine
    ): Response
    {
        $form = $this->createForm(ConfirmType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $doctrine->getManager();
            $project->removeEnvironment($environment);
            $manager->persist($project);
            $manager->flush();
            $this->addFlash('success', 'Environment unbinded from project');
            return $this->redirectToRoute('app_projects_show', [
                'project' => $project->getId()
            ]);
        }
        return $this->render('projects/unbind_environment.html.twig', [
            'form' => $form,
            'environment' => $environment,
            'project' => $project
        ]);
    }

    #[Route('/project/{project}/environment/bind', name: 'app_project_bind_environment')]
    public function bindEnvironment(
        Request $request, 
        Project $project,
        PersistenceManagerRegistry $doctrine,
        EnvironmentRepository $environmentRepository,
    ): Response
    {
        $form = $this->createForm(BindEnvironmentType::class, null, [
            'environments_list' => $environmentRepository->findBy([], ['name' => 'ASC']),
            'label' => 'Bind a receipt to project ' . $project->getName()
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $doctrine->getManager();
            $selectedEnvironment = $form->get('environment')->getData();
            foreach ($selectedEnvironment as $environment) {
                $project->addEnvironment($environment);
            }
            $manager->persist($project);
            $manager->flush();
            $this->addFlash('success', 'Environment binded to project');
            return $this->redirectToRoute('app_projects_show', [
                'project' => $project->getId()
            ]);
        }
        
        return $this->render('projects/bindEnvironment.html.twig', [
            'form' => $form,
            'project' => $project
        ]);
    }
}
