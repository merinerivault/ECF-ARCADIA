<?php

// src/Controller/RestaurantController.php
namespace App\Controller;

use App\Entity\Animal;
use App\Repository\AnimalRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
        $animal->setNom('Koko');
        $animal->setEspece('gorille');
        $animal->setDateNaissance(new \DateTime('01/01/2001'));
        $animal->setEtatSante('Malade');
        $animal->setDescription('test');
        $animal->setNourriture('Salade');
        $animal->setGrammeNourriture('100');
        $animal->setDatePassage(new \DateTime('01/01/2001'));
        $animal->setImage();
        $animal->setHabitat();
    
        $this->manager->persist($animal);
        $this->manager->flush();

        return $this->json(
            ['message'=> "Animal ressource created with {$animal->getId()} id"],
            Response::HTTP_CREATED,
        );
    }


    #[Route('/{id}', name: 'show', methods: 'GET')]
    public function show(int $id): Response
    {
        $animal = $this->repository->findOneBy(['id' => $id]);

        if (!$animal) {
            throw $this->createNotFoundException("No Animal found for {$id} id");
        }

        return $this->json(
            ['message' => "A Animal was found : {$animal->getName()} for {$animal->getId()} id"]
        );
    } 

    
    #[Route('/{id}', name: 'edit', methods: 'PUT')]
    public function edit(int $id): Response
    {
        $animal = $this->repository->findOneBy(['id' => $id]);
    
        if (!$animal) {
            throw $this->createNotFoundException("No Animal found for {$id} id");
        }
    
        $animal->setName('Animal name updated');
        $this->manager->flush();
    
        return $this->redirectToRoute('app_api_animal_show', ['id' => $animal->getId()]);
    }
    

    #[Route('/{id}', name: 'delete', methods: 'DELETE')]
    public function delete(int $id): Response
    {
        $animal = $this->repository->findOneBy(['id' => $id]);
        if (!$animal) {
            throw $this->createNotFoundException("No Animal found for {$id} id");
        }
    
        $this->manager->remove($animal);
        $this->manager->flush();
    
        return $this->json(['message' => "Animal resource deleted"], Response::HTTP_NO_CONTENT);
    }

}
