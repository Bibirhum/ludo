<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserGameAssociationRepository")
 */
class UserGameAssociation
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="associated_games")
     * @ORM\JoinColumn(nullable=false)
     */
    private $users;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Game", inversedBy="associated_users")
     * @ORM\JoinColumn(nullable=false)
     */
    private $games;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\LessThanOrEqual(5)
     * @Assert\GreaterThanOrEqual(0)
     */
    private $rating;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $commentary;

    /**
     * @ORM\Column(type="integer")
     */
    private $playsGame;

    /**
     * @ORM\Column(type="integer")
     */
    private $ownsGame;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsers(): ?User
    {
        return $this->users;
    }

    public function setUsers(?User $users): self
    {
        $this->users = $users;

        return $this;
    }

    public function getGames(): ?Game
    {
        return $this->games;
    }

    public function setGames(?Game $games): self
    {
        $this->games = $games;

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

    public function getCommentary(): ?string
    {
        return $this->commentary;
    }

    public function setCommentary(?string $commentary): self
    {
        $this->commentary = $commentary;

        return $this;
    }

    public function getPlaysGame(): ?int
    {
        return $this->playsGame;
    }

    public function setPlaysGame(int $playsGame): self
    {
        $this->playsGame = $playsGame;

        return $this;
    }

    public function getOwnsGame(): ?int
    {
        return $this->ownsGame;
    }

    public function setOwnsGame(int $ownsGame): self
    {
        $this->ownsGame = $ownsGame;

        return $this;
    }
}
