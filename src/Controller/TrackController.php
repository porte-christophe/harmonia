<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\AlbumRepository;
use App\Repository\TrackRepository;
use App\Form\TrackType;
use App\Entity\Track;


final class TrackController extends AbstractController
{
    #[Route('/track/{id}', name: 'app_track_item')]
    public function index($id, TrackRepository $trackRepository): Response
    {
        $track = $trackRepository->findOneBy(['id'=> $id]);
        //dump($track);
        if ($track === null) {
           return $this->redirectToRoute('app_home');
        }
        return $this->render('track/index.html.twig', [
            'track' => $track,
        ]);
    }
    #[Route('/add-track/{id}', name: 'app_add_track')]
    public function addTrack(EntityManagerInterface $em, Request $request, AlbumRepository $ar, $id): Response
    {
        
        $album = $ar->findOneBy(['id' =>  $id]);
        if ($album === null) {
             return $this->redirectToRoute('app_home');
        }

        $track = new Track();


        $form = $this->createForm(TrackType::class, $track);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $track->setCreatedAt(new \DateTimeImmutable());
            $track->setListenCount(0);
            $track->setAlbum($album);
            $em->persist($track);
            $em->flush();
            return $this->redirectToRoute('app_album_item', ['id' => $id]);
        }
        return $this->render('track/add.html.twig', [
            'form'=>$form,
        ]);
    }
}
