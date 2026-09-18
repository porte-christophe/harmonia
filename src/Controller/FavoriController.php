<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\FavoriRepository;
use App\Repository\TrackRepository;
use App\Entity\Favori;

final class FavoriController extends AbstractController
{
    // #[Route('/favori/{id}', name: 'app_favori')]
    // public function index($id): Response
    // {
    //     return $this->render('favori/index.html.twig', [
    //         'controller_name' => 'FavoriController',
    //     ]);
    // }
    #[Route('/handle-favorite/{id}', name: 'app_favori')]
    public function index($id, EntityManagerInterface $em, FavoriRepository $favRepo, TrackRepository $trackRepo): Response
    {
        $user = $this->getUser();
        $track = $trackRepo->findOneBy(['id'=>$id]);

        $favori = $favRepo->findOneBy(['track'=>$track,
            'user' => $user]);

        
        if ($favori === null && $user && $track) {
            $favori = new Favori();
            $favori->setCreatedAt(new \DateTimeImmutable());
            $favori->setTrack($track);
            $favori->setUser($user);
            $em->persist($favori);
            $em->flush();
        } elseif ($favori && $user && $track) {
            $em->remove($favori);
            $em->flush();
        }
        return $this->redirectToRoute('app_track_item', ['id' => $id]);
    }
}
