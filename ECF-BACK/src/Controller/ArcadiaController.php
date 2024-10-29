<?php

// src/Controller/RestaurantController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/arcadia', name: 'app_api_arcadia_')]
class ArcadiaController extends AbstractController
{
    #[Route('/{id}', name: 'edit', methods: 'PUT')]
    public function edit(int $id): Response
    {
        // … Edite le restaurant et le sauvegarde en base de données
    }

    #[Route('/{id}', name: 'delete', methods: 'DELETE')]   
    public function delete(int $id): Response
    {
        // ... Supprime le restaurant de la base de données
    }
}
