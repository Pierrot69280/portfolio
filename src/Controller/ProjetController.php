<?php

namespace App\Controller;

use App\Entity\Projet;
use App\Form\ProjetType;
use App\Repository\ProjetRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ProjetController extends AbstractController
{
    #[Route('/', name: 'app_projets')]
    public function index(ProjetRepository $projetRepository): Response
    {
        $projets = $projetRepository->findAll();

        return $this->render('projet/index.html.twig', [

            'projets' => $projets,
        ]);
    }

    #[Route('/create', name: 'app_create')]
    public function create(Request $request, EntityManagerInterface $manager):Response
    {

        $projet = new Projet();
        $form =  $this->createForm(ProjetType::class, $projet);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $manager->persist($projet);
            $manager->flush();

            return $this->redirectToRoute('app_projets', ["id"=>$projet->getId()]);
        }

        return $this->render('projet/create.html.twig',[
            'formulaire'=>$form->createView()
        ]);
    }

    #[Route('/delete/{id}', name:'app_delete')]
    public function delete(Projet $article, EntityManagerInterface $manager):Response
    {

        $manager->remove($article);
        $manager->flush();
        return $this->redirectToRoute("app_home");

    }

    #[Route('/edit/{id}', name: 'app_edit')]
    public function edit(Request $request, EntityManagerInterface $manager, Projet $projet): Response
    {
        $formulaire = $this->createForm(ProjetType::class, $projet);
        $formulaire->handleRequest($request);

        if ($formulaire->isSubmitted() && $formulaire->isValid()) {
            $manager->flush();

            return $this->redirectToRoute('app_home');
        }

        return $this->render('projet/edit.html.twig', [
            'formulaire' => $formulaire->createView()
        ]);
    }
}
