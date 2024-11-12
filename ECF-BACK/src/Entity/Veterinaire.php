<?php

namespace App\Entity;

use App\Repository\VeterinaireRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VeterinaireRepository::class)]
class Veterinaire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $specialite = null;

    /**
     * @var Collection<int, CompteRenduVeterinaire>
     */
    #[ORM\OneToMany(targetEntity: CompteRenduVeterinaire::class, mappedBy: 'veterinaire', orphanRemoval: true)]
    private Collection $compteRenduVeterinaires;

    public function __construct()
    {
        $this->compteRenduVeterinaires = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSpecialite(): ?string
    {
        return $this->specialite;
    }

    public function setSpecialite(string $specialite): static
    {
        $this->specialite = $specialite;

        return $this;
    }

    /**
     * @return Collection<int, CompteRenduVeterinaire>
     */
    public function getCompteRenduVeterinaires(): Collection
    {
        return $this->compteRenduVeterinaires;
    }

    public function addCompteRenduVeterinaire(CompteRenduVeterinaire $compteRenduVeterinaire): static
    {
        if (!$this->compteRenduVeterinaires->contains($compteRenduVeterinaire)) {
            $this->compteRenduVeterinaires->add($compteRenduVeterinaire);
            $compteRenduVeterinaire->setVeterinaire($this);
        }

        return $this;
    }

    public function removeCompteRenduVeterinaire(CompteRenduVeterinaire $compteRenduVeterinaire): static
    {
        if ($this->compteRenduVeterinaires->removeElement($compteRenduVeterinaire)) {
            // set the owning side to null (unless already changed)
            if ($compteRenduVeterinaire->getVeterinaire() === $this) {
                $compteRenduVeterinaire->setVeterinaire(null);
            }
        }

        return $this;
    }
}
