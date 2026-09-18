<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\AlbumRepository;

final class AlbumController extends AbstractController
{
    #[Route('/album/{id}', name: 'app_album_item')]
    public function index($id, AlbumRepository $albumRepository): Response
    {
        $album = $albumRepository->findOneBy(["id"=>$id]);
        //dump($album);
        if ($album === null) {
           return $this->redirectToRoute('app_home');
        }
        $totalDuration = 0;
        foreach ($album->getTracks() as $track) {
            $totalDuration += $track->getDuration();
        }
        //dump($totalDuration);
        return $this->render('album/index.html.twig', [
            'album' => $album,
            'dureeTotale' => $totalDuration,
        ]);
    }
}
