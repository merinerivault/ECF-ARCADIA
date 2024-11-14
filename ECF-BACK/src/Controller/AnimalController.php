<?php

namespace App\Controller;

use App\Entity\Animal;
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
        $animal = new Animal(); // Définir la variable employe

        // Tell Doctrine you want to (eventually) save the employe (no queries yet)
        $this->manager->persist($animal); // Utilise la bonne variable
        // Actually executes the queries (i.e. the INSERT query)
        $this->manager->flush();

        return $this->json(
            ['message' => "Animal resource created with {$animal->getId()} id"], // Utilise la bonne variable ici aussi
            Response::HTTP_CREATED,
        );
    } 
}