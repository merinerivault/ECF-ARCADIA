<?php

namespace App\Controller;

use App\Entity\Service;
use App\Repository\ImageRepository;
use App\Repository\ServiceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/service')]
class ServiceController extends AbstractController
{
    // CREATE (POST) - Créer un nouveau service
    #[Route('', name: 'service_create', methods: ['POST'])]
    public function create(
        Request $request,
        EntityManagerInterface $manager,
        ImageRepository $imageRepository
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);

        // Récupérer les informations depuis la requête
        $nom = $data['nom'] ?? null;
        $description = $data['description'] ?? null;
        $imageId = $data['image_id'] ?? null;

        // Vérifier que les champs requis sont présents
        if (!$nom || !$description || !$imageId) {
            return $this->json(['error' => 'Missing required fields.'], Response::HTTP_BAD_REQUEST);
        }

        // Récupérer l'image associée
        $image = $imageRepository->find($imageId);
        if (!$image) {
            return $this->json(['error' => 'Image not found.'], Response::HTTP_NOT_FOUND);
        }

        // Créer et remplir l'entité Service
        $service = new Service();
        $service->setNom($nom);
        $service->setDescription($description);
        $service->setImage($image);

        // Sauvegarder dans la base de données
        $manager->persist($service);
        $manager->flush();

        return $this->json([
            'message' => 'Service created successfully',
            'id' => $service->getId(),
        ], Response::HTTP_CREATED);
    }

    // READ (GET) - Récupérer tous les services
    #[Route('', name: 'service_list', methods: ['GET'])]
    public function list(ServiceRepository $serviceRepository): JsonResponse
    {
        $services = $serviceRepository->findAll();

        $data = array_map(function (Service $service) {
            return [
                'id' => $service->getId(),
                'nom' => $service->getNom(),
                'description' => $service->getDescription(),
                'image_id' => $service->getImage()?->getId(),
            ];
        }, $services);

        return $this->json($data, Response::HTTP_OK);
    }

    // READ (GET) - Récupérer un service par ID
    #[Route('/{id}', name: 'service_read', methods: ['GET'])]
    public function read(int $id, ServiceRepository $serviceRepository): JsonResponse
    {
        $service = $serviceRepository->find($id);

        if (!$service) {
            return $this->json(['error' => 'Service not found.'], Response::HTTP_NOT_FOUND);
        }

        return $this->json([
            'id' => $service->getId(),
            'nom' => $service->getNom(),
            'description' => $service->getDescription(),
            'image_id' => $service->getImage()?->getId(),
        ], Response::HTTP_OK);
    }

    // UPDATE (PUT) - Mettre à jour un service
    #[Route('/{id}', name: 'service_update', methods: ['PUT'])]
    public function update(
        int $id,
        Request $request,
        ServiceRepository $serviceRepository,
        ImageRepository $imageRepository,
        EntityManagerInterface $manager
    ): JsonResponse {
        $service = $serviceRepository->find($id);

        if (!$service) {
            return $this->json(['error' => 'Service not found.'], Response::HTTP_NOT_FOUND);
        }

        $data = json_decode($request->getContent(), true);

        // Mettre à jour les champs si présents
        if (isset($data['nom'])) {
            $service->setNom($data['nom']);
        }
        if (isset($data['description'])) {
            $service->setDescription($data['description']);
        }
        if (isset($data['image_id'])) {
            $image = $imageRepository->find($data['image_id']);
            if (!$image) {
                return $this->json(['error' => 'Image not found.'], Response::HTTP_NOT_FOUND);
            }
            $service->setImage($image);
        }

        // Sauvegarder les changements
        $manager->flush();

        return $this->json([
            'message' => 'Service updated successfully',
            'id' => $service->getId(),
        ], Response::HTTP_OK);
    }

    // DELETE (DELETE) - Supprimer un service
    #[Route('/{id}', name: 'service_delete', methods: ['DELETE'])]
    public function delete(int $id, ServiceRepository $serviceRepository, EntityManagerInterface $manager): JsonResponse
    {
        $service = $serviceRepository->find($id);

        if (!$service) {
            return $this->json(['error' => 'Service not found.'], Response::HTTP_NOT_FOUND);
        }

        $manager->remove($service);
        $manager->flush();

        return $this->json(['message' => 'Service deleted successfully'], Response::HTTP_OK);
    }
}
