<?php

namespace App\Entity;

use App\Repository\JoueurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: JoueurRepository::class)]
class Joueur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'joueurs')]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'joueurs')]
    private ?Tournoi $tournoi = null;

    /**
     * @var Collection<int, Matchs>
     */
    #[ORM\OneToMany(targetEntity: Matchs::class, mappedBy: 'joueur1')]
    private Collection $matchs;

    public function __construct()
    {
        $this->matchs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?user
    {
        return $this->user;
    }

    public function setUser(?user $user): static
    {
        $this->user = $user;

        return $this;
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

    /**
     * @return Collection<int, Matchs>
     */
    public function getMatchs(): Collection
    {
        return $this->matchs;
    }

    public function addMatch(Matchs $match): static
    {
        if (!$this->matchs->contains($match)) {
            $this->matchs->add($match);
            $match->setJoueur1($this);
        }

        return $this;
    }

    public function removeMatch(Matchs $match): static
    {
        if ($this->matchs->removeElement($match)) {
            // set the owning side to null (unless already changed)
            if ($match->getJoueur1() === $this) {
                $match->setJoueur1(null);
            }
        }

        return $this;
    }
}
