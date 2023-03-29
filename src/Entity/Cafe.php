<?php

namespace App\Entity;

use App\Repository\CafeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;

#[ORM\Entity(repositoryClass: CafeRepository::class)]
class Cafe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $pictureUrl = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $box = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $number = null;

    #[ORM\Column(length: 500)]
    private ?string $street = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $zipCode = null;

    #[ORM\Column(length: 255)]
    private ?string $city = null;

    #[ORM\Column(length: 255)]
    private ?string $country = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    private ?int $rating = null;

    #[ORM\OneToMany(mappedBy: 'cafe', targetEntity: Comment::class, orphanRemoval: true)]
    private Collection $comments;

    #[ORM\OneToMany(mappedBy: 'cafe', targetEntity: Likes::class, orphanRemoval: true)]
    private Collection $likes;

    #[ORM\OneToMany(mappedBy: 'cafe', targetEntity: Discover::class, orphanRemoval: true)]
    private Collection $discovers;

    private File $pictureFile;

    public function __construct()
    {
        $this->comments = new ArrayCollection();
        $this->likes = new ArrayCollection();
        $this->discovers = new ArrayCollection();
    }

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

    public function getPictureUrl(): ?string
    {
        return $this->pictureUrl;
    }

    public function setPictureUrl(string $pictureUrl): self
    {
        $this->pictureUrl = $pictureUrl;

        return $this;
    }
    public function getPictureFile(): ?File //recuperation le fichier jpg(eg)
    {
        return $this->pictureFile;
    }

    public function setPictureFile(File $pictureFile): self
    {
        $this->pictureFile = $pictureFile;

        return $this;
    }

    public function getBox(): ?string
    {
        return $this->box;
    }

    public function setBox(?string $box): self
    {
        $this->box = $box;

        return $this;
    }

    public function getNumber(): ?int
    {
        return $this->number;
    }

    public function setNumber(int $number): self
    {
        $this->number = $number;

        return $this;
    }

    public function getStreet(): ?string
    {
        return $this->street;
    }

    public function setStreet(string $street): self
    {
        $this->street = $street;

        return $this;
    }

    public function getZipCode(): ?int
    {
        return $this->zipCode;
    }

    public function setZipCode(int $zipCode): self
    {
        $this->zipCode = $zipCode;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getRating(): ?int
    {
        return $this->rating;
    }

    public function setRating(?int $rating): self
    {
        $this->rating = $rating;

        return $this;
    }

    /**
     * @return Collection<int, Comment>
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments->add($comment);
            $comment->setCafe($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getCafe() === $this) {
                $comment->setCafe(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Likes>
     */
    public function getLikes(): Collection
    {
        return $this->likes;
    }

    public function addLike(Likes $like): self
    {
        if (!$this->likes->contains($like)) {
            $this->likes->add($like);
            $like->setCafe($this);
        }

        return $this;
    }

    public function removeLike(Likes $like): self
    {
        if ($this->likes->removeElement($like)) {
            // set the owning side to null (unless already changed)
            if ($like->getCafe() === $this) {
                $like->setCafe(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Discover>
     */
    public function getDiscovers(): Collection
    {
        return $this->discovers;
    }

    public function addDiscover(Discover $discover): self
    {
        if (!$this->discovers->contains($discover)) {
            $this->discovers->add($discover);
            $discover->setCafe($this);
        }

        return $this;
    }

    public function removeDiscover(Discover $discover): self
    {
        if ($this->discovers->removeElement($discover)) {
            // set the owning side to null (unless already changed)
            if ($discover->getCafe() === $this) {
                $discover->setCafe(null);
            }
        }

        return $this;
    }
}
