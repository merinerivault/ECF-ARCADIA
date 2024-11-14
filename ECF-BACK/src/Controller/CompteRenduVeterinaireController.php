<?php

namespace App\Controller;

use App\Entity\CompteRenduVeterinaire;
use App\Repository\CompteRenduVeterinaireRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/compteRenduVeterinaires', name: 'app_api_compteRenduVeterinaires_')]

class CompteRenduVeterinaireController extends AbstractController
{
    public function __construct(private EntityManagerInterface $manager, private CompteRenduVeterinaireRepository $repository)
    {
    }
    
    #[Route(methods: 'POST')]
    public function new(): Response
    {
        $compteRenduVeterinaires = new CompteRenduVeterinaire (); // Définir la variable employe

        // Tell Doctrine you want to (eventually) save the employe (no queries yet)
        $this->manager->persist($compteRenduVeterinaires); // Utilise la bonne variable
        // Actually executes the queries (i.e. the INSERT query)
        $this->manager->flush();

        return $this->json(
            ['message' => "CompteRenduVeterinaire resource created with {$compteRenduVeterinaires->getId()} id"], // Utilise la bonne variable ici aussi
            Response::HTTP_CREATED,
        );
    } 
}