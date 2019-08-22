<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GameRepository")
 */
class Game
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $image;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $thumbnail;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $theme;


    /**
     * @ORM\Column(type="string", length=255)
     */
    private $short_description;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="integer")
     */
    private $numPlayerMin;

    /**
     * @ORM\Column(type="integer")
     */
    private $numPlayerMax;

    /**
     * @ORM\Column(type="integer")
     */
    private $duration;

    /**
     * @ORM\Column(type="integer")
     */
    private $ageMin;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Category", inversedBy="related_games")
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;


    /**
     * @ORM\OneToMany(targetEntity="App\Entity\UserGameAssociation", mappedBy="games", orphanRemoval=true)
     */
    private $associated_users;

    public function __construct()
    {
        $this->associated_users = new ArrayCollection();
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

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getThumbnail(): ?string
    {
        return $this->thumbnail;
    }

    public function setThumbnail(string $thumbnail): self
    {
        $this->thumbnail = $thumbnail;

        return $this;
    }

    public function getTheme(): ?string
    {
        return $this->theme;
    }

    public function setTheme(?string $theme): self
    {
        $this->theme = $theme;

        return $this;
    }

    public function getShortDescription(): ?string
    {
        return $this->short_description;
    }

    public function setShortDescription(string $short_description): self
    {
        $this->short_description = $short_description;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getNumPlayerMin(): ?int
    {
        return $this->numPlayerMin;
    }

    public function setNumPlayerMin(int $numPlayerMin): self
    {
        $this->numPlayerMin = $numPlayerMin;

        return $this;
    }

    public function getNumPlayerMax(): ?int
    {
        return $this->numPlayerMax;
    }

    public function setNumPlayerMax(int $numPlayerMax): self
    {
        $this->numPlayerMax = $numPlayerMax;

        return $this;
    }

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setDuration(int $duration): self
    {
        $this->duration = $duration;

        return $this;
    }

    public function getAgeMin(): ?int
    {
        return $this->ageMin;
    }

    public function setAgeMin(int $ageMin): self
    {
        $this->ageMin = $ageMin;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

// ajout de Baptiste pour lier un Game à un User

public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection|UserGameAssociation[]
     */
    public function getAssociatedUsers(): Collection
    {
        return $this->associated_users;
    }

    public function addAssociatedUser(UserGameAssociation $associatedUser): self
    {
        if (!$this->associated_users->contains($associatedUser)) {
            $this->associated_users[] = $associatedUser;
            $associatedUser->setGames($this);
        }

        return $this;
    }

    public function removeAssociatedUser(UserGameAssociation $associatedUser): self
    {
        if ($this->associated_users->contains($associatedUser)) {
            $this->associated_users->removeElement($associatedUser);
            // set the owning side to null (unless already changed)
            if ($associatedUser->getGames() === $this) {
                $associatedUser->setGames(null);
            }
        }

        return $this;
    }

}
