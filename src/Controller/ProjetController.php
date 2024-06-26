<?php

namespace App\Controller;

use App\Entity\Projet;
use App\Repository\ProjetRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ProjetController extends AbstractController
{
    #[Route('/projets', name: 'app_projets')]
    public function index(ProjetRepository $projetRepository): Response
    {
        $projets = $projetRepository->findAll();

        return $this->render('projet/index.html.twig', [

            'projets' => $projets,
        ]);
    }
}
