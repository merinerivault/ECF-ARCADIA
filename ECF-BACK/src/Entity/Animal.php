<?php

namespace App\Entity;

use App\Repository\AnimalRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AnimalRepository::class)]
class Animal
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $nom = null;

    #[ORM\Column(length: 150)]
    private ?string $espece = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date_naissance = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $etat_sante = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    private ?string $nourriture = null;

    #[ORM\Column]
    private ?int $gramme_nourriture = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date_passage = null;

    #[ORM\ManyToOne(inversedBy: 'animals')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Image $image = null;

    #[ORM\ManyToOne(inversedBy: 'animals')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Habitat $habitat = null;

    /**
     * @var Collection<int, CompteRenduVeterinaire>
     */
    #[ORM\OneToMany(targetEntity: CompteRenduVeterinaire::class, mappedBy: 'animal', orphanRemoval: true)]
    private Collection $compteRenduVeterinaires;

    public function __construct()
    {
        $this->compteRenduVeterinaires = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getEspece(): ?string
    {
        return $this->espece;
    }

    public function setEspece(string $espece): static
    {
        $this->espece = $espece;

        return $this;
    }

    public function getDateNaissance(): ?\DateTimeInterface
    {
        return $this->date_naissance;
    }

    public function setDateNaissance(\DateTimeInterface $date_naissance): static
    {
        $this->date_naissance = $date_naissance;

        return $this;
    }

    public function getEtatSante(): ?string
    {
        return $this->etat_sante;
    }

    public function setEtatSante(string $etat_sante): static
    {
        $this->etat_sante = $etat_sante;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getNourriture(): ?string
    {
        return $this->nourriture;
    }

    public function setNourriture(string $nourriture): static
    {
        $this->nourriture = $nourriture;

        return $this;
    }

    public function getGrammeNourriture(): ?int
    {
        return $this->gramme_nourriture;
    }

    public function setGrammeNourriture(int $gramme_nourriture): static
    {
        $this->gramme_nourriture = $gramme_nourriture;

        return $this;
    }

    public function getDatePassage(): ?\DateTimeInterface
    {
        return $this->date_passage;
    }

    public function setDatePassage(\DateTimeInterface $date_passage): static
    {
        $this->date_passage = $date_passage;

        return $this;
    }

    public function getImage(): ?image
    {
        return $this->image;
    }

    public function setImage(?image $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getHabitat(): ?habitat
    {
        return $this->habitat;
    }

    public function setHabitat(?habitat $habitat): static
    {
        $this->habitat = $habitat;

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
            $compteRenduVeterinaire->setAnimal($this);
        }

        return $this;
    }

    public function removeCompteRenduVeterinaire(CompteRenduVeterinaire $compteRenduVeterinaire): static
    {
        if ($this->compteRenduVeterinaires->removeElement($compteRenduVeterinaire)) {
            // set the owning side to null (unless already changed)
            if ($compteRenduVeterinaire->getAnimal() === $this) {
                $compteRenduVeterinaire->setAnimal(null);
            }
        }

        return $this;
    }
}
