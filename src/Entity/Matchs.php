<?php

namespace App\Entity;

use App\Repository\MatchsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MatchsRepository::class)]
class Matchs
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'matchs')]
    private ?Tournoi $tournoi = null;

    #[ORM\ManyToOne(inversedBy: 'matchs')]
    private ?joueur $joueur1 = null;

    #[ORM\ManyToOne(inversedBy: 'matchs')]
    private ?joueur $joueur2 = null;

    #[ORM\Column]
    private ?int $ScoreJoueur1 = null;

    #[ORM\Column]
    private ?int $ScoreJoueur2 = null;

    #[ORM\Column(length: 255)]
    private ?string $status = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTournoi(): ?Tournoi
    {
        return $this->tournoi;
    }

    public function setTournoi(?Tournoi $tournoi): static
    {
        $this->tournoi = $tournoi;

        return $this;
    }

    public function getJoueur1(): ?joueur
    {
        return $this->joueur1;
    }

    public function setJoueur1(?joueur $joueur1): static
    {
        $this->joueur1 = $joueur1;

        return $this;
    }

    public function getJoueur2(): ?joueur
    {
        return $this->joueur2;
    }

    public function setJoueur2(?joueur $joueur2): static
    {
        $this->joueur2 = $joueur2;

        return $this;
    }

    public function getScoreJoueur1(): ?int
    {
        return $this->ScoreJoueur1;
    }

    public function setScoreJoueur1(int $ScoreJoueur1): static
    {
        $this->ScoreJoueur1 = $ScoreJoueur1;

        return $this;
    }

    public function getScoreJoueur2(): ?int
    {
        return $this->ScoreJoueur2;
    }

    public function setScoreJoueur2(int $ScoreJoueur2): static
    {
        $this->ScoreJoueur2 = $ScoreJoueur2;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }
}
