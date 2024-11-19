<?php

namespace App\Controller;

use App\Entity\Avis;
use App\Repository\AvisRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/avis')]
class AvisController extends AbstractController
{
    // CREATE (POST)
    #[Route('', name: 'avis_create', methods: ['POST'])]
    public function createImage(Request $request, EntityManagerInterface $manager, AvisRepository $avisRepository): Response
    {
        $data = json_decode($request->getContent(), true);
        $imageId = $data['image_id'] ?? null;
        $habitatId = $data['habitat_id'] ?? null;

        // Vérification des IDs
        if (!$imageId || !$habitatId) {
            return $this->json(['error' => 'Missing image_id or habitat_id.'], Response::HTTP_BAD_REQUEST);
        }

        $avis = new Avis();
        $avis->setPseudo('test');
        $avis->setCommentaire('test');
        $avis->setDate(new \DateTime('1997-01-19'));
        $avis->setValiderLe(new \DateTime('1997-01-19'));

        $manager->persist($avis);
        $manager->flush();

        return $this->json([
            'message' => 'Avis created successfully',
            'id' => $avis->getId(),
        ], Response::HTTP_CREATED);
    }

    // READ ALL (GET)
    #[Route('', name: 'avis_read_all', methods: ['GET'])]
    public function readAll(AvisRepository $repository): Response
    {
        $avisList = $repository->findAll();

        return $this->json($avisList, Response::HTTP_OK, [], ['groups' => 'avis:read']);
    }

    // READ ONE (GET)
    #[Route('/{id}', name: 'avis_read_one', methods: ['GET'])]
    public function readOne(int $id, AvisRepository $repository): Response
    {
        $avis = $repository->find($id);

        if (!$avis) {
            return $this->json(['error' => 'Avis not found'], Response::HTTP_NOT_FOUND);
        }

        return $this->json($avis, Response::HTTP_OK, [], ['groups' => 'avis:read']);
    }

    // UPDATE (PUT)
    #[Route('/{id}', name: 'avis_update', methods: ['PUT'])]
    public function update(int $id, Request $request, EntityManagerInterface $manager, AvisRepository $repository): Response
    {
        $avis = $repository->find($id);

        if (!$avis) {
            return $this->json(['error' => 'Avis not found'], Response::HTTP_NOT_FOUND);
        }

        // Accéder directement aux paramètres de la requête (en utilisant $request->request->get())
        $pseudo = $request->request->get('pseudo');
        $commentaire = $request->request->get('commentaire');
        $date = $request->request->get('date');
        $validerLe = $request->request->get('valider_le');

        // Mettre à jour les valeurs si elles existent dans la requête
        if ($pseudo) {
            $avis->setPseudo($pseudo);
        }
        if ($commentaire) {
            $avis->setCommentaire($commentaire);
        }
        if ($date) {
            $avis->setDate(new \DateTime($date));
        }
        if ($validerLe) {
            $avis->setValiderLe(new \DateTime($validerLe));
        }

        $manager->persist($avis);
        $manager->flush();

        return $this->json([
            'message' => 'Avis updated successfully',
            'id' => $avis->getId(),
            'pseudo' => $avis->getPseudo(),
            'commentaire' => $avis->getCommentaire(),
        ], Response::HTTP_OK);
    }

    // DELETE (DELETE)
    #[Route('/{id}', name: 'avis_delete', methods: ['DELETE'])]
    public function delete(int $id, EntityManagerInterface $manager, AvisRepository $repository): Response
    {
        $avis = $repository->find($id);

        if (!$avis) {
            return $this->json(['error' => 'Avis not found'], Response::HTTP_NOT_FOUND);
        }

        $manager->remove($avis);
        $manager->flush();

        return $this->json([
            'message' => 'Avis deleted successfully',
        ], Response::HTTP_OK);
    }
}


