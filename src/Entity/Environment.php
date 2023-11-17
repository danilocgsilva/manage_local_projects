<?php

namespace App\Entity;

use App\Repository\EnvironmentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EnvironmentRepository::class)]
class Environment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $uname_n_fingerprint = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $uname_a_fingerprint = null;

    #[ORM\ManyToMany(targetEntity: Project::class, mappedBy: 'environment')]
    private Collection $projects;

    #[ORM\ManyToMany(targetEntity: EnvironmentFile::class, mappedBy: 'environment')]
    private Collection $environmentFiles;

    #[ORM\OneToMany(mappedBy: 'environment', targetEntity: DatabaseCredentials::class)]
    private Collection $databaseCredentials;

    #[ORM\ManyToMany(targetEntity: Deploy::class, mappedBy: 'encironments')]
    private Collection $deploys;

    public function __construct()
    {
        $this->projects = new ArrayCollection();
        $this->environmentFiles = new ArrayCollection();
        $this->databaseCredentials = new ArrayCollection();
        $this->deploys = new ArrayCollection();
    }

    #[ORM\Column(length: 255)]

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getUnameNFingerprint(): ?string
    {
        return $this->uname_n_fingerprint;
    }

    public function setUnameNFingerprint(?string $uname_n_fingerprint): self
    {
        $this->uname_n_fingerprint = $uname_n_fingerprint;

        return $this;
    }

    public function getUnameAFingerprint(): ?string
    {
        return $this->uname_a_fingerprint;
    }

    public function setUnameAFingerprint(?string $uname_a_fingerprint): self
    {
        $this->uname_a_fingerprint = $uname_a_fingerprint;

        return $this;
    }

    /**
     * @return Collection<int, Project>
     */
    public function getProjects(): Collection
    {
        return $this->projects;
    }

    public function addProject(Project $project): static
    {
        if (!$this->projects->contains($project)) {
            $this->projects->add($project);
            $project->addEnvironment($this);
        }

        return $this;
    }

    public function removeProject(Project $project): static
    {
        if ($this->projects->removeElement($project)) {
            $project->removeEnvironment($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, EnvironmentFile>
     */
    public function getEnvironmentFiles(): Collection
    {
        return $this->environmentFiles;
    }

    public function addEnvironmentFile(EnvironmentFile $environmentFile): static
    {
        if (!$this->environmentFiles->contains($environmentFile)) {
            $this->environmentFiles->add($environmentFile);
            $environmentFile->addEnvironment($this);
        }

        return $this;
    }

    public function removeEnvironmentFile(EnvironmentFile $environmentFile): static
    {
        if ($this->environmentFiles->removeElement($environmentFile)) {
            $environmentFile->removeEnvironment($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, DatabaseCredentials>
     */
    public function getDatabaseCredentials(): Collection
    {
        return $this->databaseCredentials;
    }

    public function addDatabaseCredential(DatabaseCredentials $databaseCredential): static
    {
        if (!$this->databaseCredentials->contains($databaseCredential)) {
            $this->databaseCredentials->add($databaseCredential);
            $databaseCredential->setEnvironment($this);
        }

        return $this;
    }

    public function removeDatabaseCredential(DatabaseCredentials $databaseCredential): static
    {
        if ($this->databaseCredentials->removeElement($databaseCredential)) {
            // set the owning side to null (unless already changed)
            if ($databaseCredential->getEnvironment() === $this) {
                $databaseCredential->setEnvironment(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Deploy>
     */
    public function getDeploys(): Collection
    {
        return $this->deploys;
    }

    public function addDeploy(Deploy $deploy): static
    {
        if (!$this->deploys->contains($deploy)) {
            $this->deploys->add($deploy);
            $deploy->addEncironment($this);
        }

        return $this;
    }

    public function removeDeploy(Deploy $deploy): static
    {
        if ($this->deploys->removeElement($deploy)) {
            $deploy->removeEncironment($this);
        }

        return $this;
    }
}
