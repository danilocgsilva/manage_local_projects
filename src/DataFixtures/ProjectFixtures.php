<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Project;
use Faker\Factory;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;

class ProjectFixtures extends Fixture implements FixtureGroupInterface
{
    public function load(ObjectManager $manager): void
    {
        $generator = Factory::create();

        $project = new Project();
        $project->setName($generator->name());
        $manager->persist($project);
        
        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['projects'];
    }
}
