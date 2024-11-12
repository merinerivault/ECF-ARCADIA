<?php

// src/Controller/RestaurantController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/animal', name: 'app_api_animal_')]
class AnimalController extends AbstractController
{
    #[Route('/{id}', name: 'new', methods: 'POST')]
    public function new(): Response
    {
        // … Edite le restaurant et le sauvegarde en base de données
    }

    #[Route('/{id}', name: 'show', methods: 'GET')]
    public function show(): Response
    {
        // … Edite le restaurant et le sauvegarde en base de données
    }
    
    #[Route('/{id}', name: 'edit', methods: 'PUT')]
    public function edit(): Response
    {
        // … Edite le restaurant et le sauvegarde en base de données
    }

    #[Route('/{id}', name: 'delete', methods: 'DELETE')]   
    public function delete(): Response
    {
        // ... Supprime le restaurant de la base de données
    }
}
