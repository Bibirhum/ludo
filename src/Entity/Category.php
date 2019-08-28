<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass="App\Repository\CategoryRepository")
 */
class Category
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank
     * @Assert\Length(
     *      min = 2,
     *      max = 50,
     *      minMessage = "The category name must be at least {{ limit }} characters long",
     *      maxMessage = "The category name cannot be longer than {{ limit }} characters"
     * )
     */
    private $name;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank
     * @Assert\Length(
     *      min = 2,
     *      max = 250,
     *      minMessage = "The category name must be at least {{ limit }} characters long",
     *      maxMessage = "The category name cannot be longer than {{ limit }} characters"
     * )
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Game", mappedBy="category")
     */
    private $related_games;

    public function __construct()
    {
        $this->related_games = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection|Game[]
     */
    public function getRelatedGames(): Collection
    {
        return $this->related_games;
    }

    public function addRelatedGame(Game $relatedGame): self
    {
        if (!$this->related_games->contains($relatedGame)) {
            $this->related_games[] = $relatedGame;
            $relatedGame->setCategory($this);
        }

        return $this;
    }

    public function removeRelatedGame(Game $relatedGame): self
    {
        if ($this->related_games->contains($relatedGame)) {
            $this->related_games->removeElement($relatedGame);
            // set the owning side to null (unless already changed)
            if ($relatedGame->getCategory() === $this) {
                $relatedGame->setCategory(null);
            }
        }

        return $this;
    }
}
