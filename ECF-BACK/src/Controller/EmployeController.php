<?php

namespace App\Controller;

use App\Entity\Employe;
use App\Repository\EmployeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/employe')]
class EmployeController extends AbstractController
{
    // CREATE (POST)
    #[Route('', name: 'employe_create', methods: ['POST'])]
    public function createImage(EntityManagerInterface $manager): Response
    {

        // Créer un nouvel employé
        $employe = new Employe();

        // Persister et sauvegarder
        $manager->persist($employe);
        $manager->flush();

        return $this->json([
            'message' => 'Employe created successfully',
            'id' => $employe->getId(),
        ], Response::HTTP_CREATED);
    }

    // READ ALL (GET)
    #[Route('/{id}', name: 'employe_read_all', methods: ['GET'])]
    public function readAll(EmployeRepository $repository): Response
    {
        // Récupérer tous les employés
        $employes = $repository->findAll();

        // Retourner la liste des employés
        return $this->json($employes, Response::HTTP_OK, [], ['groups' => 'employe:read']);
    }

    // READ ONE (GET)
    #[Route('/{id}', name: 'employe_read_one', methods: ['GET'])]
    public function readOne(int $id, EmployeRepository $repository): Response
    {
        // Récupérer un employé par son ID
        $employe = $repository->find($id);

        if (!$employe) {
            return $this->json(['error' => 'Employe not found'], Response::HTTP_NOT_FOUND);
        }

        return $this->json($employe, Response::HTTP_OK, [], ['groups' => 'employe:read']);
    }

    // UPDATE (PUT)
    #[Route('/{id}', name: 'employe_update', methods: ['PUT'])]
    public function update(int $id, Request $request, EntityManagerInterface $manager, EmployeRepository $repository): Response
    {
        // Récupérer l'employé existant
        $employe = $repository->find($id);

        if (!$employe) {
            return $this->json(['error' => 'Employe not found'], Response::HTTP_NOT_FOUND);
        }

        // Récupérer les nouvelles données envoyées
        $nom = $request->request->get('nom');
        $prenom = $request->request->get('prenom');
        $email = $request->request->get('email');
        $poste = $request->request->get('poste');

        // Mettre à jour les données de l'employé si elles sont présentes
        if ($nom) {
            $employe->setNom($nom);
        }
        if ($prenom) {
            $employe->setPrenom($prenom);
        }
        if ($email) {
            $employe->setEmail($email);
        }
        if ($poste) {
            $employe->setPoste($poste);
        }

        // Sauvegarder les modifications
        $manager->persist($employe);
        $manager->flush();

        return $this->json([
            'message' => 'Employe updated successfully',
            'id' => $employe->getId(),
            'nom' => $employe->getNom(),
            'prenom' => $employe->getPrenom(),
        ], Response::HTTP_OK);
    }

    // DELETE (DELETE)
    #[Route('/{id}', name: 'employe_delete', methods: ['DELETE'])]
    public function delete(int $id, EntityManagerInterface $manager, EmployeRepository $repository): Response
    {
        // Récupérer l'employé à supprimer
        $employe = $repository->find($id);

        if (!$employe) {
            return $this->json(['error' => 'Employe not found'], Response::HTTP_NOT_FOUND);
        }

        // Supprimer l'employé
        $manager->remove($employe);
        $manager->flush();

        return $this->json([
            'message' => 'Employe deleted successfully',
        ], Response::HTTP_OK);
    }
}

