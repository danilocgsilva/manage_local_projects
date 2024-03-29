<?php

namespace App\Entity;

use App\Repository\DeployRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DeployRepository::class)]
class Deploy
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToMany(targetEntity: Environment::class, inversedBy: 'deploys')]
    private Collection $environments;

    #[ORM\ManyToMany(targetEntity: Receipt::class, inversedBy: 'deploys')]
    private Collection $receipts;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'deployments')]
    private ?Project $project = null;

    #[ORM\Column(length: 255)]
    private ?string $fileSystemProjectPath = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $dockerVolumeMountPath = null;

    public function __construct()
    {
        $this->environments = new ArrayCollection();
        $this->receipts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Environment>
     */
    public function getEnvironments(): Collection
    {
        return $this->environments;
    }

    public function addEnvironment(Environment $environment): static
    {
        if (!$this->environments->contains($environment)) {
            $this->environments->add($environment);
        }

        return $this;
    }

    public function removeEnvironment(Environment $environment): static
    {
        $this->environments->removeElement($environment);

        return $this;
    }

    /**e
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
        }

        return $this;
    }

    public function removeReceipt(Receipt $receipt): static
    {
        $this->receipts->removeElement($receipt);

        return $this;
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

    public function getProject(): ?Project
    {
        return $this->project;
    }

    public function setProject(?Project $project): static
    {
        $this->project = $project;

        return $this;
    }

    public function getFileSystemProjectPath(): ?string
    {
        return $this->fileSystemProjectPath;
    }

    public function setFileSystemProjectPath(string $fileSystemProjectPath): static
    {
        $this->fileSystemProjectPath = $fileSystemProjectPath;

        return $this;
    }

    public function getDockerVolumeMountPath(): ?string
    {
        return $this->dockerVolumeMountPath;
    }

    public function setDockerVolumeMountPath(?string $dockerVolumeMountPath): static
    {
        $this->dockerVolumeMountPath = $dockerVolumeMountPath;

        return $this;
    }
}
