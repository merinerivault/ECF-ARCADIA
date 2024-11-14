<?php

namespace App\Controller;

use App\Entity\Image;
use App\Repository\ImageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/image', name: 'app_api_image_')]

class ImageController extends AbstractController
{
    public function __construct(private EntityManagerInterface $manager, private ImageRepository $repository)
    {
    }
    
    #[Route(methods: 'POST')]
    public function new(): Response
    {
        $image = new Image(); // Définir la variable employe

        // Tell Doctrine you want to (eventually) save the employe (no queries yet)
        $this->manager->persist($image); // Utilise la bonne variable
        // Actually executes the queries (i.e. the INSERT query)
        $this->manager->flush();

        return $this->json(
            ['message' => "Image resource created with {$image->getId()} id"], // Utilise la bonne variable ici aussi
            Response::HTTP_CREATED,
        );
    } 
}
