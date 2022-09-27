<?php

namespace App\Controller;

use App\Repository\PostRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class MainController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function show(PostRepository $postRepository, UserRepository $userRepository): Response
    {
        $posts = $postRepository->findAll();
        return $this->render('main/home.html.twig', [
            'posts' => $posts
        ]);
    }
}
