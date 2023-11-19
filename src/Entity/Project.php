<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\ProjectRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Mapping\Annotation as Gedmo;
use App\Enums\ProjectType;
use InvalidArgumentException;

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
        // options: [ "default" => ProjectType::Normal ]
        options: [ "default" => "Normal" ]
    )]
    private string $type;

    #[ORM\OneToOne(mappedBy: 'project', cascade: ['persist', 'remove'])]
    private ?GitAddress $gitAddress = null;

    #[ORM\ManyToMany(targetEntity: Environment::class, inversedBy: 'projects')]
    private Collection $environment;

    #[ORM\ManyToMany(targetEntity: Receipt::class, mappedBy: 'projects')]
    private Collection $receipts;

    #[ORM\OneToMany(mappedBy: 'project', targetEntity: Deploy::class)]
    private Collection $deployments;

    public function __construct()
    {
        $this->environment = new ArrayCollection();
        $this->receipts = new ArrayCollection();
        $this->deployments = new ArrayCollection();
    }


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
            throw new InvalidArgumentException("Invalid status");
        }
        
        $this->type = $type;
    
        return $this;
    }
    public function getGitAddress(): ?GitAddress
    {
        return $this->gitAddress;
    }

    public function setGitAddress(?GitAddress $gitAddress): static
    {
        // unset the owning side of the relation if necessary
        if ($gitAddress === null && $this->gitAddress !== null) {
            $this->gitAddress->setProject(null);
        }

        // set the owning side of the relation if necessary
        if ($gitAddress !== null && $gitAddress->getProject() !== $this) {
            $gitAddress->setProject($this);
        }

        $this->gitAddress = $gitAddress;

        return $this;
    }

    /**
     * @return Collection<int, Environment>
     */
    public function getEnvironment(): Collection
    {
        return $this->environment;
    }

    public function addEnvironment(Environment $environment): static
    {
        if (!$this->environment->contains($environment)) {
            $this->environment->add($environment);
        }

        return $this;
    }

    public function removeEnvironment(Environment $environment): static
    {
        $this->environment->removeElement($environment);

        return $this;
    }

    /**
     * @return Collection<int, Receipt>
     */
    public function getReceipts(): Collection
    {
        return $this->receipts;
    }

    public function addReceipt(Receipt $receipt): static
    {
        if (!$this->receipts->contains($receipt)) {
            $this->receipts->add($receipt);
            $receipt->addProject($this);
        }

        return $this;
    }

    public function removeReceipt(Receipt $receipt): static
    {
        if ($this->receipts->removeElement($receipt)) {
            $receipt->removeProject($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Deploy>
     */
    public function getDeployments(): Collection
    {
        return $this->deployments;
    }

    public function addDeployment(Deploy $deployment): static
    {
        if (!$this->deployments->contains($deployment)) {
            $this->deployments->add($deployment);
            $deployment->setProject($this);
        }

        return $this;
    }

    public function removeDeployment(Deploy $deployment): static
    {
        if ($this->deployments->removeElement($deployment)) {
            // set the owning side to null (unless already changed)
            if ($deployment->getProject() === $this) {
                $deployment->setProject(null);
            }
        }

        return $this;
    }
}
