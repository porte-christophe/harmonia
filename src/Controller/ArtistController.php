<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\ArtistRepository;
use App\Form\ArtistType;
use App\Entity\Artist;

final class ArtistController extends AbstractController
{
    #[Route('/artist', name: 'app_artist')]
    public function index(ArtistRepository $ar): Response
    {
        $artists = $ar->findAll();
        
        return $this->render('artist/index.html.twig', [
            'artists' => $artists,
        ]);
    }

    #[Route('/artist-add', name: 'app_artist_add')]
    public function createArtist(EntityManagerInterface $em, Request $request): Response
    {
        
        $artist = new Artist();
        $form = $this->createForm(ArtistType::class, $artist);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $artist->setCreatedAt(new \DateTimeImmutable());
            $em->persist($artist);
            $em->flush();
            return $this->redirectToRoute('app_artist');
        }
        return $this->render('artist/add.html.twig', [
            'form'=>$form,
        ]);
    }

    #[Route('/artist-edit/{id}', name: 'app_artist_edit')]
    public function editArtist(EntityManagerInterface $em, Request $request, ArtistRepository $ar, $id): Response
    {
        
        $artist = $ar->findOneBy(['id' =>  $id]);

        if ($artist === null) {
            return $this->redirectToRoute('app_artist');
        }


        $form = $this->createForm(ArtistType::class, $artist);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($artist);
            $em->flush();
            return $this->redirectToRoute('app_artist');
        }
        return $this->render('artist/add.html.twig', [
            'form'=>$form,
        ]);
    }
}
