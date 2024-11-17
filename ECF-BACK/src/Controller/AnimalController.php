<?php

namespace App\Controller;

use App\Entity\Animal;
use App\Repository\AnimalRepository;
use App\Repository\ImageRepository;
use App\Repository\HabitatRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/animal')]
class AnimalController extends AbstractController
{
    // CREATE (POST) - Créer un animal
    #[Route('', name: 'animal_create', methods: ['POST'])]
    public function createImage(Request $request, EntityManagerInterface $manager, ImageRepository $imageRepository, HabitatRepository $habitatRepository): Response
    {
        // Get and validate image_id and habitat_id from request
        $imageId = $request->request->get('image_id');
        $habitatId = $request->request->get('habitat_id');
        
        if (!$imageId || !$habitatId) {
            return $this->json(['error' => 'Image ID and Habitat ID are required'], Response::HTTP_BAD_REQUEST);
        }

        $image = $imageRepository->find($imageId);
        $habitat = $habitatRepository->find($habitatId);
        
        if (!$image || !$habitat) {
            return $this->json(['error' => 'Image or Habitat not found'], Response::HTTP_NOT_FOUND);
        }

        $animal = new Animal();
        $animal->setNom('test');
        $animal->setEspece('test');
        $animal->setDateNaissance(new \DateTime('1997-01-19'));
        $animal->setEtatSante('test');
        $animal->setDescription('test');
        $animal->setNourriture('test');
        $animal->setGrammeNourriture('100');
        $animal->setDatePassage(new \DateTime('1997-01-19'));
        $animal->setImage($image);
        $animal->setHabitat($habitat);

        $manager->persist($animal);
        $manager->flush();

        return $this->json([
            'message' => 'Animal created successfully',
            'id' => $animal->getId(),
        ], Response::HTTP_CREATED);
    }    // READ ALL (GET) - Lire tous les animaux
    #[Route('/{id}', name: 'animal_read_all', methods: ['GET'])]
    public function readAll(AnimalRepository $repository): Response
    {
        // Récupérer tous les animaux
        $animals = $repository->findAll();

        return $this->json($animals, Response::HTTP_OK, [], ['groups' => 'animal:read']);
    }

    // READ ONE (GET) - Lire un animal par ID
    #[Route('/{id}', name: 'animal_read_one', methods: ['GET'])]
    public function readOne(int $id, AnimalRepository $repository): Response
    {
        // Récupérer l'animal par son ID
        $animal = $repository->find($id);

        if (!$animal) {
            return $this->json(['error' => 'Animal not found'], Response::HTTP_NOT_FOUND);
        }

        return $this->json($animal, Response::HTTP_OK, [], ['groups' => 'animal:read']);
    }

    // UPDATE (PUT) - Mettre à jour un animal
    #[Route('/{id}', name: 'animal_update', methods: ['PUT'])]
    public function update(int $id, Request $request, EntityManagerInterface $manager, AnimalRepository $repository, ImageRepository $imageRepository, HabitatRepository $habitatRepository): Response
    {
        // Récupérer l'animal à mettre à jour
        $animal = $repository->find($id);

        if (!$animal) {
            return $this->json(['error' => 'Animal not found'], Response::HTTP_NOT_FOUND);
        }

        // Récupérer les nouvelles données de la requête
        $nom = $request->request->get('nom');
        $espece = $request->request->get('espece');
        $date_naissance = $request->request->get('date_naissance'); // format: YYYY-MM-DD
        $etat_sante = $request->request->get('etat_sante');
        $description = $request->request->get('description');
        $nourriture = $request->request->get('nourriture');
        $gramme_nourriture = $request->request->get('gramme_nourriture');
        $date_passage = $request->request->get('date_passage'); // format: YYYY-MM-DD
        $imageId = $request->request->get('image_id');
        $habitatId = $request->request->get('habitat_id');

        // Validation des données
        if ($nom) $animal->setNom($nom);
        if ($espece) $animal->setEspece($espece);
        if ($date_naissance) $animal->setDateNaissance(new \DateTime($date_naissance));
        if ($etat_sante) $animal->setEtatSante($etat_sante);
        if ($description) $animal->setDescription($description);
        if ($nourriture) $animal->setNourriture($nourriture);
        if ($gramme_nourriture) $animal->setGrammeNourriture($gramme_nourriture);
        if ($date_passage) $animal->setDatePassage(new \DateTime($date_passage));

        // Mise à jour des relations (image, habitat)
        if ($imageId) {
            $image = $imageRepository->find($imageId);
            if ($image) $animal->setImage($image);
        }

        if ($habitatId) {
            $habitat = $habitatRepository->find($habitatId);
            if ($habitat) $animal->setHabitat($habitat);
        }

        // Sauvegarder les modifications
        $manager->persist($animal);
        $manager->flush();

        return $this->json([
            'message' => 'Animal updated successfully',
            'id' => $animal->getId(),
        ], Response::HTTP_OK);
    }

    // DELETE (DELETE) - Supprimer un animal
    #[Route('/{id}', name: 'animal_delete', methods: ['DELETE'])]
    public function delete(int $id, EntityManagerInterface $manager, AnimalRepository $repository): Response
    {
        // Récupérer l'animal à supprimer
        $animal = $repository->find($id);

        if (!$animal) {
            return $this->json(['error' => 'Animal not found'], Response::HTTP_NOT_FOUND);
        }

        // Supprimer l'animal
        $manager->remove($animal);
        $manager->flush();

        return $this->json([
            'message' => 'Animal deleted successfully',
        ], Response::HTTP_OK);
    }
}
