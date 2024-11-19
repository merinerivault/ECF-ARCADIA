<?php

namespace App\Controller;

use App\Entity\Veterinaire;
use App\Repository\VeterinaireRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/veterinaire')]
class VeterinaireController extends AbstractController
{
    // CREATE (POST)
    #[Route('', name: 'veterinaire_create', methods: ['POST'])]
    public function createImage(EntityManagerInterface $manager): Response
    {
        $veterinaire = new Veterinaire();
        $veterinaire->setSpecialite('test');

        $manager->persist($veterinaire);
        $manager->flush();

        return $this->json([
            'message' => 'Veterinaire created successfully',
            'id' => $veterinaire->getId(),
        ], Response::HTTP_CREATED);
    }

    // READ ALL (GET)
    #[Route('', name: 'veterinaire_read_all', methods: ['GET'])]
    public function readAll(VeterinaireRepository $repository): Response
    {
        $veterinaireList = $repository->findAll();

        return $this->json($veterinaireList, Response::HTTP_OK, [], ['groups' => 'veterinaire:read']);
    }

    // READ ONE (GET)
    #[Route('/{id}', name: 'veterinaire_read_one', methods: ['GET'])]
    public function readOne(int $id, VeterinaireRepository $repository): Response
    {
        $veterinaire = $repository->find($id);

        if (!$veterinaire) {
            return $this->json(['error' => 'Veterinaire not found'], Response::HTTP_NOT_FOUND);
        }

        return $this->json($veterinaire, Response::HTTP_OK, [], ['groups' => 'veterinaire:read']);
    }

    // UPDATE (PUT)
    #[Route('/{id}', name: 'veterinaire_update', methods: ['PUT'])]
    public function update(int $id, Request $request, EntityManagerInterface $manager, VeterinaireRepository $repository): Response
    {
        $veterinaire = $repository->find($id);

        if (!$veterinaire) {
            return $this->json(['error' => 'Veterinaire not found'], Response::HTTP_NOT_FOUND);
        }

        // Accéder directement aux paramètres de la requête (en utilisant $request->request->get())
        $specialite = $request->request->get('specialite');

        // Mettre à jour les valeurs si elles existent dans la requête
        if ($specialite) {
            $veterinaire->setSpecialite($specialite);
        }

        $manager->persist($veterinaire);
        $manager->flush();

        return $this->json([
            'message' => 'Veterinaire updated successfully',
            'id' => $veterinaire->getId(),
            'specialite' => $veterinaire->getSpecialite(),
        ], Response::HTTP_OK);
    }

    // DELETE (DELETE)
    #[Route('/{id}', name: 'veterinaire_delete', methods: ['DELETE'])]
    public function delete(int $id, EntityManagerInterface $manager, VeterinaireRepository $repository): Response
    {
        $veterinaire = $repository->find($id);

        if (!$veterinaire) {
            return $this->json(['error' => 'Veterinaire not found'], Response::HTTP_NOT_FOUND);
        }

        $manager->remove($veterinaire);
        $manager->flush();

        return $this->json([
            'message' => 'Veterinaire deleted successfully',
        ], Response::HTTP_OK);
    }
}
