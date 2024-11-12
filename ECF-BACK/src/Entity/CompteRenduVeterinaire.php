<?php

namespace App\Entity;

use App\Repository\CompteRenduVeterinaireRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CompteRenduVeterinaireRepository::class)]
class CompteRenduVeterinaire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $rapport = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\ManyToOne(inversedBy: 'compteRenduVeterinaires')]
    #[ORM\JoinColumn(nullable: false)]
    private ?veterinaire $veterinaire = null;

    #[ORM\ManyToOne(inversedBy: 'compteRenduVeterinaires')]
    #[ORM\JoinColumn(nullable: false)]
    private ?animal $animal = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRapport(): ?string
    {
        return $this->rapport;
    }

    public function setRapport(string $rapport): static
    {
        $this->rapport = $rapport;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getVeterinaire(): ?veterinaire
    {
        return $this->veterinaire;
    }

    public function setVeterinaire(?veterinaire $veterinaire): static
    {
        $this->veterinaire = $veterinaire;

        return $this;
    }

    public function getAnimal(): ?animal
    {
        return $this->animal;
    }

    public function setAnimal(?animal $animal): static
    {
        $this->animal = $animal;

        return $this;
    }

}
