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
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/api/service')]
class ServiceController extends AbstractController
{
    private SerializerInterface $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    // CREATE (POST)
    #[Route('', name: 'service_create', methods: ['POST'])]
    public function create(
        Request $request,
        EntityManagerInterface $manager,
        ImageRepository $imageRepository,
        ValidatorInterface $validator
    ): JsonResponse {
        $data = $request->getContent();

        try {
            $service = $this->serializer->deserialize($data, Service::class, 'json');
        } catch (\Exception $e) {
            return $this->json(['error' => 'Invalid JSON: ' . $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }

        $decodedData = json_decode($data, true);
        $imageId = $decodedData['image_id'] ?? null;

        if (!$imageId) {
            return $this->json(['error' => 'Missing image_id.'], Response::HTTP_BAD_REQUEST);
        }

        $image = $imageRepository->find($imageId);

        if (!$image) {
            return $this->json(['error' => 'Image not found.'], Response::HTTP_NOT_FOUND);
        }

        $service->setImage($image);

        // Validate the Service entity
        $errors = $validator->validate($service);
        if (count($errors) > 0) {
            return $this->json(['error' => (string) $errors], Response::HTTP_BAD_REQUEST);
        }

        $manager->persist($service);
        $manager->flush();
        return $this->json(['message' => 'Service created successfully', 'id' => $service->getId()], Response::HTTP_CREATED);
    }

    // READ ALL (GET)
    #[Route('', name: 'service_list', methods: ['GET'])]
    public function list(ServiceRepository $serviceRepository): JsonResponse
    {
        $services = $serviceRepository->findAll();
        $json = $this->serializer->serialize($services, 'json', ['groups' => 'service:read']);

        return new JsonResponse($json, Response::HTTP_OK, [], true);
    }

    // READ ONE (GET)
    #[Route('/{id}', name: 'service_read', methods: ['GET'])]
    public function read(Service $service): JsonResponse
    {
        $json = $this->serializer->serialize($service, 'json', ['groups' => 'service:read']);
        return new JsonResponse($json, Response::HTTP_OK, [], true);
    }

    // UPDATE (PUT)
    #[Route('/{id}', name: 'service_update', methods: ['PUT'])]
    public function update(
        Service $service,
        Request $request,
        EntityManagerInterface $manager,
        ImageRepository $imageRepository,
        ValidatorInterface $validator
    ): JsonResponse {
        $data = $request->getContent();
        $decodedData = json_decode($data, true);

        try {
            $this->serializer->deserialize($data, Service::class, 'json', ['object_to_populate' => $service]);
        } catch (\Exception $e) {
            return $this->json(['error' => 'Invalid JSON: ' . $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }

        $imageId = $decodedData['image_id'] ?? null;

        if ($imageId) {
            $image = $imageRepository->find($imageId);
            if (!$image) {
                return $this->json(['error' => 'Image not found.'], Response::HTTP_NOT_FOUND);
            }
            $service->setImage($image);
        }

        $errors = $validator->validate($service);
        if (count($errors) > 0) {
            return $this->json(['error' => (string) $errors], Response::HTTP_BAD_REQUEST);
        }

        $manager->flush();

        return $this->json(['message' => 'Service updated successfully'], Response::HTTP_OK);
    }

    // DELETE (DELETE)
    #[Route('/{id}', name: 'service_delete', methods: ['DELETE'])]
    public function delete(Service $service, EntityManagerInterface $manager): JsonResponse
    {
        $manager->remove($service);
        $manager->flush();

        return $this->json(['message' => 'Service deleted successfully'], Response::HTTP_OK);
    }
}

