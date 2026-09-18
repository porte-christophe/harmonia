<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\StyleRepository;

final class StyleController extends AbstractController
{
    #[Route('/style/{id}', name: 'app_style')]
    public function index($id, StyleRepository $styleRepository): Response
    {
        $style = $styleRepository->findOneBy(['id'=> $id]);
        if ($style === null) {
           return $this->redirectToRoute('app_home');
        }

        return $this->render('style/index.html.twig', [
            'style' => $style,
        ]);
    }
}
