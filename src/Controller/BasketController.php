<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Sneaker;
use App\Repository\BasketRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

// #[IsGranted('ROLE_USER')]

class BasketController extends AbstractController
{
    #[Route('/mon-panier', name: 'app_basket_affiche')]
    public function affiche(): Response
    {
        return $this->render('basket/affichage.html.twig');
    }

    

}
