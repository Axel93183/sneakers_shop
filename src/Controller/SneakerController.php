<?php

namespace App\Controller;

use App\Repository\SneakerRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SneakerController extends AbstractController
{
    #[Route('/home', name: 'app_sneaker_home')]
    public function home(SneakerRepository $sneakerRepository): Response
    {
        //por recupérer les sneakers (entityRepository)

        $sneakers= $sneakerRepository->findAll();

        return $this->render('sneaker/home.html.twig', [
            'sneakers' => $sneakers,
            'controller_name' => 'Sneakers\' Shop ',
        ]);
    }
}
