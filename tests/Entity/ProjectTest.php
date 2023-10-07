<?php

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\Project;
use App\Enums\ProjectType;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Exception;

class ProjectsControllerTest extends KernelTestCase
{
    /**
     * @dataProvider availableDatabasesOptions
     */
    public function testSetType($option): void
    {
        $projectType = $option;
        $project = new Project();
        $project->setType($projectType);
        $this->assertSame($projectType, $project->getType());
    }

    public function testSetWrongType(): void
    {
        $projectType = "anything";
        $project = new Project();

        $this->expectException(Exception::class);
        $project->setType($projectType);
    }

    
    public function availableDatabasesOptions()
    {
        return [
            ["Database"],
            ["Normal"],
            [ProjectType::Database->name],
            [ProjectType::Normal->name]
        ];
    }
}
