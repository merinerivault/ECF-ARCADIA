<?php

namespace App\Entity;
use App\Repository\CompteRenduVeterinaireRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: CompteRenduVeterinaireRepository::class)]
class CompteRenduVeterinaire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['compte_rendu:read'])]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(['compte_rendu:read', 'compte_rendu:write'])]
    private ?string $rapport = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(['compte_rendu:read', 'compte_rendu:write'])]
    private ?\DateTimeInterface $date = null;

    #[ORM\ManyToOne(inversedBy: 'compteRenduVeterinaires')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['compte_rendu:read', 'compte_rendu:write'])]
    private ?Veterinaire $veterinaire = null;

    #[ORM\ManyToOne(inversedBy: 'compteRenduVeterinaires')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['compte_rendu:read', 'compte_rendu:write'])]
    private ?Animal $animal = null;

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

    public function getVeterinaire(): ?Veterinaire
    {
        return $this->veterinaire;
    }

    public function setVeterinaire(?Veterinaire $veterinaire): static
    {
        $this->veterinaire = $veterinaire;

        return $this;
    }

    public function getAnimal(): ?Animal
    {
        return $this->animal;
    }

    public function setAnimal(?Animal $animal): static
    {
        $this->animal = $animal;

        return $this;
    }

}
