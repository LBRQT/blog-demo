<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user')]
    public function index(): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

     /**
     * @Route("/add", name="app_user_new", methods={"GET", "POST"})
     */
    public function new(Request $request, UserPasswordHasherInterface $passwordHasher, UserRepository $userRepository): Response
    {
        // On créer un nouvel utilisateur
        $user = new User();

        //Nous appelons le formulaire
        $form = $this->createForm(UserType::class, $user);
        
        // Ceci est la méthode qui détecte la requête envoyée
        $form->handleRequest($request);

        // On vérifie si le formulaire est valide et bien envoyé
        if ($form->isSubmitted() && $form->isValid()) {

            // actuellement le mot de passe n'est pas haché dans le user
            // on récupère le service UserPasswordHasherInterface 
            // pour hasher le mot de passe à la mano
            $passwordClear = $user->getPassword();
            $hashedPassword = $passwordHasher->hashPassword($user, $passwordClear);
            $user->setPassword($hashedPassword);

            // cette méthode fait le persist et le flush !
            $userRepository->add($user, true);

            // On retourne l'utilisateur vers la homepage
            return $this->redirectToRoute('home', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user/new.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

}
