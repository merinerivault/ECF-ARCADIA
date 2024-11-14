<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Repository\UtilisateurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/utilisateur', name: 'app_api_utilisateur_')]

class UtilisateurController extends AbstractController
{
    public function __construct(private EntityManagerInterface $manager, private UtilisateurRepository $repository)
    {
    }
    
    #[Route(methods: 'POST')]
    public function new(): Response
    {
        $utilisateur = new Utilisateur(); // Définir la variable employe
        $utilisateur->setNom('nom');
        $utilisateur->setPrenom('prenom');
        $utilisateur->setUsername('username');
        $utilisateur->setPassword('password');
        $utilisateur->setRole('Veterinaire');

        // Tell Doctrine you want to (eventually) save the employe (no queries yet)
        $this->manager->persist($utilisateur); // Utilise la bonne variable
        // Actually executes the queries (i.e. the INSERT query)
        $this->manager->flush();

        return $this->json(
            ['message' => "Utilisateur resource created with {$utilisateur->getId()} id"], // Utilise la bonne variable ici aussi
            Response::HTTP_CREATED,
        );
    } 
}
