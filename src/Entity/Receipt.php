<?php

namespace App\Entity;

use App\Repository\ReceiptRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReceiptRepository::class)]
class Receipt
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $receipt = null;

    #[ORM\OneToMany(mappedBy: 'receipt', targetEntity: ReceiptFile::class, orphanRemoval: true)]
    private Collection $receiptFiles;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\ManyToMany(targetEntity: Project::class, inversedBy: 'receipts')]
    private Collection $projects;

    #[ORM\ManyToMany(targetEntity: Deploy::class, mappedBy: 'receipts')]
    private Collection $deploys;

    public function __construct()
    {
        $this->receiptFiles = new ArrayCollection();
        $this->projects = new ArrayCollection();
        $this->deploys = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReceipt(): ?string
    {
        return $this->receipt;
    }

    public function setReceipt(string $receipt): static
    {
        $this->receipt = $receipt;

        return $this;
    }

    /**
     * @return Collection<int, ReceiptFile>
     */
    public function getReceiptFiles(): Collection
    {
        return $this->receiptFiles;
    }

    public function addReceiptFile(ReceiptFile $receiptFile): static
    {
        if (!$this->receiptFiles->contains($receiptFile)) {
            $this->receiptFiles->add($receiptFile);
            $receiptFile->setReceipt($this);
        }

        return $this;
    }

    public function removeReceiptFile(ReceiptFile $receiptFile): static
    {
        if ($this->receiptFiles->removeElement($receiptFile)) {
            // set the owning side to null (unless already changed)
            if ($receiptFile->getReceipt() === $this) {
                $receiptFile->setReceipt(null);
            }
        }

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

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
        }

        return $this;
    }

    public function removeProject(Project $project): static
    {
        $this->projects->removeElement($project);

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
            $deploy->addReceipt($this);
        }

        return $this;
    }

    public function removeDeploy(Deploy $deploy): static
    {
        if ($this->deploys->removeElement($deploy)) {
            $deploy->removeReceipt($this);
        }

        return $this;
    }
}
