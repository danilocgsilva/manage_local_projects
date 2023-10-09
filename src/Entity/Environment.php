<?php

namespace App\Entity;

use App\Repository\EnvironmentRepository;
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

    #[ORM\ManyToOne(inversedBy: 'environment')]
    private ?Project $project = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $uname_n_fingerprint = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $uname_a_fingerprint = null;

    #[ORM\OneToOne(mappedBy: 'environment', cascade: ['persist', 'remove'])]
    private ?Receipt $receipt = null;

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

    public function getProject(): ?Project
    {
        return $this->project;
    }

    public function setProject(?Project $project): self
    {
        $this->project = $project;

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

    public function getReceipt(): ?Receipt
    {
        return $this->receipt;
    }

    public function setReceipt(?Receipt $receipt): static
    {
        // unset the owning side of the relation if necessary
        if ($receipt === null && $this->receipt !== null) {
            $this->receipt->setEnvironment(null);
        }

        // set the owning side of the relation if necessary
        if ($receipt !== null && $receipt->getEnvironment() !== $this) {
            $receipt->setEnvironment($this);
        }

        $this->receipt = $receipt;

        return $this;
    }
}
