<?php

namespace App\Controller;

use App\Entity\Admin;
use App\Repository\AdminRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/admin')]
class AdminController extends AbstractController
{
    // CREATE (POST) - Créer un nouvel Admin
    #[Route('', name: 'admin_create', methods: ['POST'])]
    public function create(Request $request, EntityManagerInterface $manager): JsonResponse
    {
        // Créer une nouvelle instance d'Admin
        $admin = new Admin();

        // Sauvegarder l'entité Admin
        $manager->persist($admin);
        $manager->flush();

        return $this->json([
            'message' => 'Admin created successfully',
            'id' => $admin->getId(),
        ], Response::HTTP_CREATED);
    }

    // READ (GET) - Obtenir tous les Admins
    #[Route('', name: 'admin_list', methods: ['GET'])]
    public function list(AdminRepository $adminRepository): JsonResponse
    {
        $admins = $adminRepository->findAll();

        $data = array_map(function (Admin $admin) {
            return [
                'id' => $admin->getId(),
            ];
        }, $admins);

        return $this->json($data, Response::HTTP_OK);
    }

    // READ (GET) - Obtenir un Admin par ID
    #[Route('/{id}', name: 'admin_read', methods: ['GET'])]
    public function read(int $id, AdminRepository $adminRepository): JsonResponse
    {
        $admin = $adminRepository->find($id);

        if (!$admin) {
            return $this->json(['error' => 'Admin not found.'], Response::HTTP_NOT_FOUND);
        }

        return $this->json([
            'id' => $admin->getId(),
        ], Response::HTTP_OK);
    }

    // UPDATE (PUT) - Mettre à jour un Admin
    #[Route('/{id}', name: 'admin_update', methods: ['PUT'])]
    public function update(int $id, Request $request, AdminRepository $adminRepository, EntityManagerInterface $manager): JsonResponse
    {
        $admin = $adminRepository->find($id);

        if (!$admin) {
            return $this->json(['error' => 'Admin not found.'], Response::HTTP_NOT_FOUND);
        }

        // Ajouter ici les champs que vous souhaitez mettre à jour si nécessaires
        // Exemple :
        // $data = json_decode($request->getContent(), true);
        // $admin->setSomeProperty($data['some_property']);

        $manager->flush();

        return $this->json([
            'message' => 'Admin updated successfully',
            'id' => $admin->getId(),
        ], Response::HTTP_OK);
    }

    // DELETE (DELETE) - Supprimer un Admin
    #[Route('/{id}', name: 'admin_delete', methods: ['DELETE'])]
    public function delete(int $id, AdminRepository $adminRepository, EntityManagerInterface $manager): JsonResponse
    {
        $admin = $adminRepository->find($id);

        if (!$admin) {
            return $this->json(['error' => 'Admin not found.'], Response::HTTP_NOT_FOUND);
        }

        $manager->remove($admin);
        $manager->flush();

        return $this->json([
            'message' => 'Admin deleted successfully',
        ], Response::HTTP_OK);
    }
}

