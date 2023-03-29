<?php

namespace App\Entity;

use App\Repository\DiscoverRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DiscoverRepository::class)]
class Discover
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'discovers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'discovers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Cafe $cafe = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getCafe(): ?Cafe
    {
        return $this->cafe;
    }

    public function setCafe(?Cafe $cafe): self
    {
        $this->cafe = $cafe;

        return $this;
    }
}
