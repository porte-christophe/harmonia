<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use App\Repository\AlbumRepository;
use App\Form\AlbumType;
use App\Entity\Album;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

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


    #[Route('/album-create', name: 'app_album_add')]
    public function createAlbum(
        EntityManagerInterface $em, 
        Request $request, 
        SluggerInterface $slugger,
        ParameterBagInterface $params
    ): Response
    {

        $jacketsDirectory = $params->get('upload_dir');

        $album = new Album();
        $form = $this->createForm(AlbumType::class, $album);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $jacketFile = $form->get('jacket')->getData();

            // this condition is needed because the 'jacket' field is not required
            // so the file must be processed only when a file is uploaded
            if ($jacketFile) {
                $originalFilename = pathinfo($jacketFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$jacketFile->guessExtension();

                // Move the file to the directory where jackets are stored
                try {
                    $jacketFile->move($jacketsDirectory, $newFilename);
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'jacketFilename' property to store the file name
                // instead of its contents
                $album->setJacket("uploads/" . $newFilename);
            }

            $album->setCreatedAt(new \DateTimeImmutable());
            $em->persist($album);
            $em->flush();
            return $this->redirectToRoute('app_home');
        }
        return $this->render('album/add.html.twig', [
            'form'=>$form,
        ]);
    }
}
