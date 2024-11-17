<?php

namespace App\Controller;

use App\Entity\Image;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ImageController extends AbstractController
{
    #[Route('/api/image', methods: ['POST'])]
    public function createImage(EntityManagerInterface $manager): Response
    {
        $image = new Image();
        $image->setNom('jungle');
        $image->setPath('/images/habitats/Jungle.jpg');

        $manager->persist($image);
        $manager->flush();

        return $this->json([
            'message' => 'Image created successfully',
            'id' => $image->getId(),
        ], Response::HTTP_CREATED);
    }
    
    #[Route('/api/image/{id}', name: 'show', methods: ['GET'])]
    public function show(int $id, EntityManagerInterface $manager): Response
    {
        $repository = $manager->getRepository(Image::class);
        $image = $repository->find($id);

        if (!$image) {
            throw $this->createNotFoundException("No Image found for ID {$id}");
        }

        return $this->json([
            'message' => "Image found: {$image->getNom()}",
            'id' => $image->getId(),
        ]);
    }

}
