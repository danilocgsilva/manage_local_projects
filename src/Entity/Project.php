<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\ProjectRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Mapping\Annotation as Gedmo;
use App\Enums\ProjectType;

#[ORM\Table(name: "projects")]
#[ORM\Entity(repositoryClass: ProjectRepository::class)]
#[Gedmo\SoftDeleteable(fieldName: 'deletedAt', timeAware: false, hardDelete: false)]
class Project
{
    use SoftDeleteableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(
        length: 32, 
        type: 'string', 
        columnDefinition: "ENUM('Normal','Database')", 
        nullable: false, 
        options: [ "default" => ProjectType::Normal ]
    )]
    private string $type;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $path = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        if (!in_array($type, [
            ProjectType::Normal->name,
            ProjectType::Database->name
        ])) {
            throw new \InvalidArgumentException("Invalid status");
        }
        
        $this->type = $type;
    
        return $this;
    }

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath(?string $path): static
    {
        $this->path = $path;

        return $this;
    }
}
