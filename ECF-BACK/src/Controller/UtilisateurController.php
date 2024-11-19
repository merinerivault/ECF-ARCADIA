<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Repository\UtilisateurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/utilisateur', name: 'utilisateur_')]
class UtilisateurController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(UtilisateurRepository $repository): Response
    {
        $utilisateurs = $repository->findAll();

        return $this->json($utilisateurs);
    }

    #[Route('/', name: 'create', methods: ['POST'])]
    public function create(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);

        $utilisateur = new Utilisateur();
        $utilisateur->setNom($data['nom'] ?? '')
                    ->setPrenom($data['prenom'] ?? '')
                    ->setUsername($data['username'] ?? '')
                    ->setPassword(password_hash($data['password'], PASSWORD_BCRYPT))
                    ->setRole($data['role'] ?? 'user');

        $this->entityManager->persist($utilisateur);
        $this->entityManager->flush();

        return $this->json(['message' => 'Utilisateur créé avec succès!', 'id' => $utilisateur->getId()], 201);
    }

    #[Route('/{id}', name: 'show', methods: ['GET'])]
    public function show(int $id, UtilisateurRepository $repository): Response
    {
        $utilisateur = $repository->find($id);

        if (!$utilisateur) {
            return $this->json(['message' => 'Utilisateur non trouvé'], 404);
        }

        return $this->json($utilisateur);
    }

    #[Route('/update/{id}', name: 'update', methods: ['PUT'])]
    public function update(Request $request, int $id, UtilisateurRepository $repository): Response
    {
        $utilisateur = $repository->find($id);

        if (!$utilisateur) {
            return $this->json(['message' => 'Utilisateur non trouvé'], 404);
        }

        $data = json_decode($request->getContent(), true);

        $utilisateur->setNom($data['nom'] ?? $utilisateur->getNom())
                    ->setPrenom($data['prenom'] ?? $utilisateur->getPrenom())
                    ->setUsername($data['username'] ?? $utilisateur->getUsername())
                    ->setRole($data['role'] ?? $utilisateur->getRole());

        if (!empty($data['password'])) {
            $utilisateur->setPassword(password_hash($data['password'], PASSWORD_BCRYPT));
        }

        $this->entityManager->flush();

        return $this->json(['message' => 'Utilisateur mis à jour avec succès!']);
    }

    #[Route('/delete/{id}', name: 'delete', methods: ['DELETE'])]
    public function delete(int $id, UtilisateurRepository $repository): Response
    {
        $utilisateur = $repository->find($id);

        if (!$utilisateur) {
            return $this->json(['message' => 'Utilisateur non trouvé'], 404);
        }

        $this->entityManager->remove($utilisateur);
        $this->entityManager->flush();

        return $this->json(['message' => 'Utilisateur supprimé avec succès!']);
    }
}
