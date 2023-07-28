<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Project;
use Doctrine\ORM\EntityManagerInterface;

class ProjectsController extends AbstractController
{
    #[Route('/projects', name: 'app_projects')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $projectRepository = $entityManager->getRepository(Project::class);
        
        return $this->render('projects/index.html.twig', [
            'environmentMode' => $this->getParameter('kernel.environment')
        ]);
    }
}
