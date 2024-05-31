<?php

namespace App\Entity;

use App\Repository\BenevolatRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BenevolatRepository::class)]
class Benevolat
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name:'id_benevolat')]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $heure_debut_benevolat = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $heure_fin_benevolat = null;

    #[ORM\Column(nullable: true)]
    private ?int $nombre_total_benevolat = null;

    #[ORM\OneToMany(targetEntity: Formulaires::class, mappedBy: 'benevolat')]
    private Collection $benevolat_id;

    public function __construct()
    {
        $this->benevolat_id = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHeureDebutBenevolat(): ?\DateTimeInterface
    {
        return $this->heure_debut_benevolat;
    }

    public function setHeureDebutBenevolat(\DateTimeInterface $heure_debut_benevolat): static
    {
        $this->heure_debut_benevolat = $heure_debut_benevolat;

        return $this;
    }

    public function getHeureFinBenevolat(): ?\DateTimeInterface
    {
        return $this->heure_fin_benevolat;
    }

    public function setHeureFinBenevolat(\DateTimeInterface $heure_fin_benevolat): static
    {
        $this->heure_fin_benevolat = $heure_fin_benevolat;

        return $this;
    }

    public function getNombreTotalBenevolat(): ?int
    {
        return $this->nombre_total_benevolat;
    }

    public function setNombreTotalBenevolat(?int $nombre_total_benevolat): static
    {
        $this->nombre_total_benevolat = $nombre_total_benevolat;

        return $this;
    }

    /**
     * @return Collection<int, Formulaires>
     */
    public function getBenevolatId(): Collection
    {
        return $this->benevolat_id;
    }

    public function addBenevolatId(Formulaires $benevolatId): static
    {
        if (!$this->benevolat_id->contains($benevolatId)) {
            $this->benevolat_id->add($benevolatId);
            $benevolatId->setBenevolat($this);
        }

        return $this;
    }

    public function removeBenevolatId(Formulaires $benevolatId): static
    {
        if ($this->benevolat_id->removeElement($benevolatId)) {
            // set the owning side to null (unless already changed)
            if ($benevolatId->getBenevolat() === $this) {
                $benevolatId->setBenevolat(null);
            }
        }

        return $this;
    }
}
