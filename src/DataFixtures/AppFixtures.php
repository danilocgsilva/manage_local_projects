<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Project;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $projectsNames = [
            "My Database",
            "Medicine time",
            "Personal Website"
        ];

        foreach ($projectsNames as $projectName) {
            $project = new Project();
            $project->setName($projectName);
            $manager->persist($project);
        }

        $manager->flush();
    }
}
