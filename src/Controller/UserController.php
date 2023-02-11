<?php

namespace App\Controller;

use App\Form\RegistrationType;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserController extends AbstractController
{
    #[Route('/inscription', name: 'app_user_registration')]
    public function registration(Request $request,UserPasswordHasherInterface $hasher,UserRepository $repository): Response
    {
        //création du formulaire
        $form = $this->createForm(RegistrationType::class);

        //on rempli le form avec les données de l'utilisateur
        $form->handleRequest($request);
         //verification si le form est envoyé et est valide
         if($form->isSubmitted() && $form->isValid()){
            //AVEC CECI ICI, sont récupérées TOUTES LES DONNEES de l'utilisateur
            $user= $form->getData();
            //crypter le mot de passe
            $cryptedPass= $hasher->hashPassword($user , $user->getPassword()); 
            //transforme en hash le password (avant en clair)***   
            $user->setPassword($cryptedPass);
    
            //Enregistrer l'utilisateur dans la base de données
            $repository->save($user, true);
            //redirection vers la page d'accueil
            return $this->redirectToRoute('app_user_home');
                    
    
         }
         return $this->render('user/registration.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/home', name: 'app_user_home')]
    public function home():Response{
        return $this->render('user/home.html.twig', [
            'controller_name' => 'Axel GMX',
        ]);
    }
}
