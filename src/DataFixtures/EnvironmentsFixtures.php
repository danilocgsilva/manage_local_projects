<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use App\Entity\Environment;

class EnvironmentsFixtures extends Fixture implements FixtureGroupInterface
{
    public function load(ObjectManager $manager): void
    {
        $generator = Factory::create();

        $environment = new Environment();
        $environment->setName($generator->name());
        $manager->persist($environment);
        
        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['environments'];
    }
}
