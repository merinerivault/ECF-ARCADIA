<?php

namespace App\Controller;

use App\Entity\Habitat;
use App\Entity\Animal;
use App\Repository\HabitatRepository;
use App\Repository\ImageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/habitat', name: 'habitat_')]
class HabitatController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(HabitatRepository $repository): Response
    {
        $habitats = $repository->findAll();

        return $this->json($habitats);
    }

    #[Route('/', name: 'create', methods: ['POST'])]
    public function create(Request $request, ImageRepository $imageRepository): Response
    {
        $data = json_decode($request->getContent(), true);

        $image = $imageRepository->find($data['image_id'] ?? null);
        if (!$image) {
            return $this->json(['message' => 'Image non trouvée'], 404);
        }

        $habitat = new Habitat();
        $habitat->setNom($data['nom'] ?? '')
                ->setDescription($data['description'] ?? '')
                ->setImage($image);

        $this->entityManager->persist($habitat);
        $this->entityManager->flush();

        return $this->json(['message' => 'Habitat créé avec succès!', 'id' => $habitat->getId()], 201);
    }

    #[Route('/{id}', name: 'show', methods: ['GET'])]
    public function show(int $id, HabitatRepository $repository): Response
    {
        $habitat = $repository->find($id);

        if (!$habitat) {
            return $this->json(['message' => 'Habitat non trouvé'], 404);
        }

        return $this->json($habitat);
    }

    #[Route('/{id}', name: 'update', methods: ['PUT'])]
    public function update(Request $request, int $id, HabitatRepository $repository, ImageRepository $imageRepository): Response
    {
        $habitat = $repository->find($id);

        if (!$habitat) {
            return $this->json(['message' => 'Habitat non trouvé'], 404);
        }

        $data = json_decode($request->getContent(), true);

        $habitat->setNom($data['nom'] ?? $habitat->getNom())
                ->setDescription($data['description'] ?? $habitat->getDescription());

        if (!empty($data['image_id'])) {
            $image = $imageRepository->find($data['image_id']);
            if ($image) {
                $habitat->setImage($image);
            }
        }

        $this->entityManager->flush();

        return $this->json(['message' => 'Habitat mis à jour avec succès!']);
    }

    #[Route('/{id}', name: 'delete', methods: ['DELETE'])]
    public function delete(int $id, HabitatRepository $repository): Response
    {
        $habitat = $repository->find($id);

        if (!$habitat) {
            return $this->json(['message' => 'Habitat non trouvé'], 404);
        }

        $this->entityManager->remove($habitat);
        $this->entityManager->flush();

        return $this->json(['message' => 'Habitat supprimé avec succès!']);
    }

    #[Route('/{id}/animals', name: 'animals', methods: ['GET'])]
    public function listAnimals(int $id, HabitatRepository $repository): Response
    {
        $habitat = $repository->find($id);

        if (!$habitat) {
            return $this->json(['message' => 'Habitat non trouvé'], 404);
        }

        $animals = $habitat->getAnimals();

        return $this->json($animals->toArray());
    }

    #[Route('/{id}/add-animal', name: 'add_animal', methods: ['POST'])]
    public function addAnimal(Request $request, int $id, HabitatRepository $repository): Response
    {
        $habitat = $repository->find($id);

        if (!$habitat) {
            return $this->json(['message' => 'Habitat non trouvé'], 404);
        }

        $data = json_decode($request->getContent(), true);
        $animal = new Animal();
        $animal->setNom($data['nom'] ?? '')
               ->setHabitat($habitat);

        $this->entityManager->persist($animal);
        $this->entityManager->flush();

        return $this->json(['message' => 'Animal ajouté avec succès!', 'animal_id' => $animal->getId()], 201);
    }
}

