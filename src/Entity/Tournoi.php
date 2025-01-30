<?php

namespace App\Entity;

use App\Repository\TournoiRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TournoiRepository::class)]
class Tournoi
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $status = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    /**
     * @var Collection<int, Joueur>
     */
    #[ORM\OneToMany(targetEntity: Joueur::class, mappedBy: 'tournoi')]
    private Collection $joueurs;

    #[ORM\ManyToOne(inversedBy: 'tournois')]
    private ?Type $type = null;

    /**
     * @var Collection<int, Matchs>
     */
    #[ORM\OneToMany(targetEntity: Matchs::class, mappedBy: 'tournoi')]
    private Collection $matchs;

    #[ORM\ManyToOne(inversedBy: 'tournois')]
    private ?user $User = null;

    public function __construct()
    {
        $this->joueurs = new ArrayCollection();
        $this->matchs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }

    /**
     * @return Collection<int, Joueur>
     */
    public function getJoueurs(): Collection
    {
        return $this->joueurs;
    }

    public function addJoueur(Joueur $joueur): static
    {
        if (!$this->joueurs->contains($joueur)) {
            $this->joueurs->add($joueur);
            $joueur->setTournoi($this);
        }

        return $this;
    }

    public function removeJoueur(Joueur $joueur): static
    {
        if ($this->joueurs->removeElement($joueur)) {
            // set the owning side to null (unless already changed)
            if ($joueur->getTournoi() === $this) {
                $joueur->setTournoi(null);
            }
        }

        return $this;
    }

    public function getType(): ?Type
    {
        return $this->type;
    }

    public function setType(?Type $type): static
    {
        $this->type = $type;

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
            $match->setTournoi($this);
        }

        return $this;
    }

    public function removeMatch(Matchs $match): static
    {
        if ($this->matchs->removeElement($match)) {
            // set the owning side to null (unless already changed)
            if ($match->getTournoi() === $this) {
                $match->setTournoi(null);
            }
        }

        return $this;
    }

    public function getUser(): ?user
    {
        return $this->User;
    }

    public function setUser(?user $User): static
    {
        $this->User = $User;

        return $this;
    }
}
