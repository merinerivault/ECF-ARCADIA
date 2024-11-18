<?php

namespace App\Controller;

use App\Entity\CompteRenduVeterinaire;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

#[Route('/api/comptes-rendus')]
class CompteRenduVeterinaireController extends AbstractController
{
    #[Route('', name: 'get_all_comptes_rendus', methods: ['GET'])]
    public function getAll(EntityManagerInterface $entityManager): JsonResponse
    {
        $comptesRendus = $entityManager->getRepository(CompteRenduVeterinaire::class)->findAll();
        return $this->json($comptesRendus, 200, [], ['groups' => 'compte_rendu:read']);
    }

    #[Route('/{id}', name: 'get_compte_rendu', methods: ['GET'])]
    public function getOne(CompteRenduVeterinaire $compteRendu): JsonResponse
    {
        return $this->json($compteRendu, 200, [], ['groups' => 'compte_rendu:read']);
    }

    #[Route('', name: 'create_compte_rendu', methods: ['POST'])]
    public function create(Request $request, SerializerInterface $serializer, EntityManagerInterface $entityManager): JsonResponse
    {
        $compteRendu = $serializer->deserialize($request->getContent(), CompteRenduVeterinaire::class, 'json');
        $entityManager->persist($compteRendu);
        $entityManager->flush();
        
        return $this->json($compteRendu, 201, [], ['groups' => 'compte_rendu:read']);
    }

    #[Route('/{id}', name: 'update_compte_rendu', methods: ['PUT'])]
    public function update(Request $request, CompteRenduVeterinaire $compteRendu, SerializerInterface $serializer, EntityManagerInterface $entityManager): JsonResponse
    {
        $serializer->deserialize($request->getContent(), CompteRenduVeterinaire::class, 'json', ['object_to_populate' => $compteRendu]);
        $entityManager->flush();
        
        return $this->json($compteRendu, 200, [], ['groups' => 'compte_rendu:read']);
    }

    #[Route('/{id}', name: 'delete_compte_rendu', methods: ['DELETE'])]
    public function delete(CompteRenduVeterinaire $compteRendu, EntityManagerInterface $entityManager): JsonResponse
    {
        $entityManager->remove($compteRendu);
        $entityManager->flush();
        
        return new JsonResponse(null, 204);
    }
}
