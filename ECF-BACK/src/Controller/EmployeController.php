<?php

namespace App\Controller;

use App\Entity\Employe;
use App\Repository\EmployeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/employe', name: 'app_api_employe_')]

class EmployeController extends AbstractController
{
    public function __construct(private EntityManagerInterface $manager, private EmployeRepository $repository)
    {
    }
    
    #[Route(methods: 'POST')]
    public function new(): Response
    {
        $employe = new Employe(); // Définir la variable employe

        // Tell Doctrine you want to (eventually) save the employe (no queries yet)
        $this->manager->persist($employe); // Utilise la bonne variable
        // Actually executes the queries (i.e. the INSERT query)
        $this->manager->flush();

        return $this->json(
            ['message' => "Employe resource created with {$employe->getId()} id"], // Utilise la bonne variable ici aussi
            Response::HTTP_CREATED,
        );
    } 
}
