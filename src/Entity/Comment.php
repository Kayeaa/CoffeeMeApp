<?php

namespace App\Entity;

use App\Repository\CommentRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommentRepository::class)]
class Comment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?\DateTime $createDate = null;

    #[ORM\Column(length: 500)]
    private ?string $message = null;

    #[ORM\ManyToOne(inversedBy: 'comments')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Cafe $cafe = null;

    #[ORM\ManyToOne(inversedBy: 'comment')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getcreateDate(): ?\DateTime
    {
        return $this->createDate;
    }

    public function setcreateDate(\DateTime $createDate): self
    {
        $this->createDate = $createDate;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function __construct()
    {
        $this->createDate = new \DateTime();
    }


}
