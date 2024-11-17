<?php

namespace App\Controller;


use Symfony\Component\HttpFoundation\Request;
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
    #[Route('/api/image/{id}', name: 'update', methods: ['PUT'])]
    public function update(int $id, Request $request, EntityManagerInterface $manager): Response
    {
        $repository = $manager->getRepository(Image::class);
        $image = $repository->find($id);

        if (!$image) {
            throw $this->createNotFoundException("No Image found for ID {$id}");
        }

        // Récupérez les données envoyées dans la requête
        $data = json_decode($request->getContent(), true);

        if (isset($data['nom'])) {
            $image->setNom($data['nom']);
        }

        if (isset($data['path'])) {
            $image->setPath($data['path']);
        }

        // Sauvegarder les modifications
        $manager->persist($image);
        $manager->flush();

        return $this->json([
            'message' => "Image with ID {$id} updated successfully.",
            'id' => $image->getId(),
            'nom' => $image->getNom(),
            'path' => $image->getPath(),
        ], Response::HTTP_OK);
    }
    
    #[Route('/api/image/{id}', name: 'delete', methods: ['DELETE'])]
    public function delete(int $id, EntityManagerInterface $manager): Response
    {
        $repository = $manager->getRepository(Image::class);
        $image = $repository->find($id);

        if (!$image) {
            throw $this->createNotFoundException("No Image found for ID {$id}");
        }

        // Supprimez l'image
        $manager->remove($image);
        $manager->flush();

        return $this->json([
            'message' => "Image with ID {$id} deleted successfully.",
        ], Response::HTTP_OK);
    }

}
