<?php

namespace App\Controller;

use App\Form\RegistrationType;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class UserController extends AbstractController
{
    //POUR S INSCRIRE
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
            return $this->redirectToRoute('app_sneaker_home');
                    
    
         }
         return $this->render('user/registration.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    // #[Route('/home', name: 'app_user_home')]
    // public function home():Response{
    //     return $this->render('user/home.html.twig', [
    //         'controller_name' => 'Sneakers\' Shop ',
    //     ]);
    // }

    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
