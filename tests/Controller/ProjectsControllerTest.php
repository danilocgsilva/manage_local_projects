<?php

declare(strict_types=1);

namespace App\Tests\Controller;

use App\Enums\ProjectType;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Entity\Project;
use Faker\Factory;

class ProjectsControllerTest extends WebTestCase
{
    private $webClient;

    public function setUp(): void
    {
        $this->webClient = static::createClient();
    }
    
    public function testProjectsRouteBasic(): void
    {
        $this->webClient->request('GET', '/projects');

        $this->assertResponseIsSuccessful();
    }

    public function testProjectNewRouteBasic(): void
    {
        $crawler = $this->webClient->request('GET', '/projects/new');

        $this->assertResponseIsSuccessful();
    }

    public function testPathShow(): void
    {
        self::bootKernel();

        $entityManager = static::$kernel->getContainer()
            ->get('doctrine.orm.entity_manager');

        $project = $this->pullProjectFromDatabase($entityManager);

        $this->webClient->request('GET', '/projects/' . $project->getId());

        $this->assertResponseIsSuccessful();
    }

    public function testDeleteFormPath(): void
    {
        self::bootKernel();
        $entityManager = static::$kernel->getContainer()
            ->get('doctrine.orm.entity_manager');
        $project = $this->pullProjectFromDatabase($entityManager);

        $this->webClient->request('GET', '/projects/' . $project->getId() . '/delete');

        $this->assertResponseIsSuccessful();
    }

    public function testRemoval(): void
    {
        self::bootKernel();
        $entityManager = static::$kernel->getContainer()
            ->get('doctrine.orm.entity_manager');
        $project = $this->pullProjectFromDatabase($entityManager);
        $projectRepository = $entityManager->getRepository(Project::class);
        $foundProjects = $projectRepository->findAll();
        $projectsCount = count($foundProjects);

        $crawler = $this->webClient->request('GET', '/projects/' . $project->getId() . '/delete');
        $form = $crawler->selectButton('delete_submit')->form();
        $this->webClient->submit($form);
        $this->assertTrue($this->webClient->getResponse()->isRedirect());

        $this->assertSame(
            $projectsCount - 1, 
            count($projectRepository->findAll())
        );
    }

    public function testCreateEnvironmentForProjectTest(): void
    {
        self::bootKernel();
        $entityManager = static::$kernel->getContainer()
            ->get('doctrine.orm.entity_manager');
        $testProject = $this->pullProjectFromDatabase($entityManager);
        
        $path = 'projects/' . ($projectId = $testProject->getId()) . '/environment/new';
        $crawler = $this->webClient->request('GET', $path);
        $this->assertResponseIsSuccessful();
    }

    private function pullProjectFromDatabase($entityManager)
    {
        $projectRepository = $entityManager->getRepository(Project::class);
        $foundProjects = $projectRepository->findAll();
        if (count($foundProjects)) {
            return $foundProjects[0];
        }
        $generator = Factory::create();
        $project = new Project();
        $project->setName($generator->name());
        $project->setType(ProjectType::Normal->name);

        $entityManager->persist($project);
        $entityManager->flush();

        return $project;
    }
}
