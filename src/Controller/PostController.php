<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostType;
use DateTimeImmutable;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

#[Route('/post', name:'post_')]
class PostController extends AbstractController
{
    #[Route('/post', name:'show')]
    public function show(): Response
    {
        return $this->render('post/index.html.twig', [
            'controller_name' => 'PostController',
        ]);
    }

    #[Route('/add', name:'add', methods:['POST', 'GET'])]
    public function add(UserInterface $user, Request $request, EntityManagerInterface $em){
    
        $newPost = new Post();
        $form = $this->createForm(PostType::class, $newPost);
        $newPost->setCreatedAt(new DateTimeImmutable('now'));
        $newPost->setUser($user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $em->persist($newPost);
            $em->flush($newPost);

            return $this->redirectToRoute('home', ['Article crée'], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('post/_add.html.twig', [
            'post' => $newPost,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name:'edit', methods:['GET', 'POST'])]
    public function edit(Post $post, EntityManagerInterface $em, Request $request)
    {
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $em->persist($post);
            $em->flush($post);

            return $this->redirectToRoute('home', ['Article modifié'], Response::HTTP_SEE_OTHER);
        }
        return $this->renderForm('post/_add.html.twig', [
            'post' => $post,
            'form' => $form,
        ]);
    }
}
