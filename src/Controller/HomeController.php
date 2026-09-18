<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\AlbumRepository;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(AlbumRepository $albumsRepository): Response
    {

        $eps = $albumsRepository->findBy(["type" => "EP"]);
        $albums = $albumsRepository->findBy(["type" => "Album"]);
        $singles = $albumsRepository->findBy(["type" => "Single"]);

        $user = $this->getUser();
        dump($user);
        return $this->render('home/index.html.twig', [
            'eps' => $eps,
            'albums' => $albums,
            'singles' => $singles,
        ]);
    }
}
