<?php

namespace App\Controller;

use App\Entity\Animal;
use App\Entity\Habitat;
use App\Entity\Image;
use App\Repository\AnimalRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/animal', name: 'app_api_animal_')]

class AnimalController extends AbstractController
{
    public function __construct(private EntityManagerInterface $manager, private AnimalRepository $repository)
    {
    }
    
    #[Route(methods: 'POST')]
public function new(): Response
{
    $animal = new Animal();
    $animal->setNom('test');
    $animal->setEspece('test');
    $animal->setDateNaissance(new \DateTime('1997-01-19'));
    $animal->setDescription('test');
    $animal->setDatePassage(new \DateTime('1997-01-19'));
    $animal->setEtatSante('test');
    $animal->setGrammeNourriture(100);
    $animal->setNourriture('test');

    // Récupérer un habitat existant
    $habitat = $this->manager->getRepository(Habitat::class)->findOneBy(['nom' => 'jungle']);
    if (!$habitat) {
        throw new \Exception('Habitat not found');
    }
    $animal->setHabitat($habitat);

    // Récupérer une image existante
    $image = $this->manager->getRepository(Image::class)->findOneBy(['path' => '11']);
    if (!$image) {
        throw new \Exception('Image not found');
    }
    $animal->setImage($image);

    $this->manager->persist($animal);
    $this->manager->flush();

    return $this->json(
        ['message' => "Animal resource created with {$animal->getId()} id"],
        Response::HTTP_CREATED,
    );
}
}