<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\PostRepository;

class MainController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function show(PostRepository $postRepository): Response
    {

        $posts = $postRepository->findAll();
        return $this->render('main/home.html.twig', [
            'posts' => $posts,
        ]);
    }
}
