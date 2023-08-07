<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Project;

class PathController extends AbstractController
{
    #[Route('/project/{project}/path/new', name: 'app_project_path_new')]
    public function new(Project $project): Response
    {
        return $this->render('path/new.html.twig', [
            'project' => $project,
        ]);
    }
}
