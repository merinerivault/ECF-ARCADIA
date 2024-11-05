<?php

namespace App\Entity;

use App\Repository\VeterinaireRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VeterinaireRepository::class)]
class Veterinaire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $specialité = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSpecialité(): ?string
    {
        return $this->specialité;
    }

    public function setSpecialité(string $specialité): static
    {
        $this->specialité = $specialité;

        return $this;
    }
}
