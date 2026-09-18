<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\PlaylistRepository;

final class PlaylistController extends AbstractController
{
    #[Route('/playlist/{id}', name: 'app_playlist')]
    public function index($id, PlaylistRepository $playlistRepository): Response
    {
        $playlist = $playlistRepository->findOneBy(["id"=>$id]);
        return $this->render('playlist/index.html.twig', [
            'playlist' => $playlist,
        ]);
    }
}
