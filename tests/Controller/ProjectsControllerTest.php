<?php

declare(strict_types=1);

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Entity\Project;
use Faker\Factory;
use Doctrine\Persistence\ManagerRegistry as PersistenceManagerRegistry;

class ProjectsControllerTest extends WebTestCase
{
    public function testProjectsRouteBasic(): void
    {
        
        $client = static::createClient();
        $crawler = $client->request('GET', '/projects');

        $this->assertResponseIsSuccessful();
    }

    public function testProjectNewRouteBasic(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/projects/new');

        $this->assertResponseIsSuccessful();
    }

    public function testPathShow(): void
    {
        $client = static::createClient();
        self::bootKernel();

        $entityManager = static::$kernel->getContainer()
            ->get('doctrine.orm.entity_manager');

        $projectRepository = $entityManager->getRepository(Project::class);
        $foundProjects = $projectRepository->findAll();
        if (count($foundProjects)) {
            $projectId = $foundProjects[0]->getId();
        } else {
            $generator = Factory::create();
            $project = new Project();
            $project->setName($generator->name());

            $manager = $entityManager->getManager();
            
            $manager->persist($project);
            $manager->flush();

            $projectId = $project->getId();
        }


        $crawler = $client->request('GET', '/projects/' . $projectId);

        $this->assertResponseIsSuccessful();
    }
}
