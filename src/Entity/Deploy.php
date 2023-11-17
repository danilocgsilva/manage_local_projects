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
    private Collection $environment;

    #[ORM\ManyToMany(targetEntity: Receipt::class, inversedBy: 'deploys')]
    private Collection $receipts;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    public function __construct()
    {
        $this->environment = new ArrayCollection();
        $this->receipts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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
}
