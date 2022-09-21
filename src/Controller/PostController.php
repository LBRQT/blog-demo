<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostType;
use App\Repository\CommentRepository;
use App\Repository\PostRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

#[Route('/post', name:'post_')]
class PostController extends AbstractController
{


    #[Route('/{id}', name:'show', methods:['GET'], requirements:['id' => '\d+'])]
    public function show($id, PostRepository $postRepository, CommentRepository $commentRepository): Response
    {
        $post= $postRepository->find($id);

        $comments= $commentRepository->findBy(['post' => $post->getId()]) === null;
         
        return $this->render('post/index.html.twig', [
            'post' => $post,
            'comments' => $comments
        ]);
    }

    #[Route('/add', name:'add', methods:['GET', 'POST'])]
    public function add(UserInterface $user, Request $request, EntityManagerInterface $em){
    
        // Verify if user is connected
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $newPost = new Post();

        // Create form with the template we configured in \Form\PostType
        // we target our new post
        $form = $this->createForm(PostType::class, $newPost);

        // We auto configure the date so it setup itself to the current date
        $newPost->setCreatedAt(new DateTimeImmutable('now'));

        // We set the User to the connected user we get from UserInterface
        $newPost->setUser($user);

        // Verify that the request is sent
        $form->handleRequest($request);

        // Verify if form is correct
        if($form->isSubmitted() && $form->isValid())
        {
            // register the new post
            $em->persist($newPost);
            $em->flush($newPost);

            // Redirect to homepage
            return $this->redirectToRoute('home', ['Article créé'], Response::HTTP_CREATED);
        }

        // The way to the form
        return $this->renderForm('post/_add.html.twig', [
            'post' => $newPost,
            'form' => $form,
        ]);
    }

    /**
     * Edit a post
     * Need to be connected and owner of the said post
     */
    #[Route('/{id}/edit', name:'edit', methods:['GET', 'POST'])]
    public function edit(UserInterface $user , Post $post, EntityManagerInterface $em, Request $request)
    {
        // Check if we are connected
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        // Check if connected user id correspond to the post user id
        if($user->getId() != $post->getUser()->getId())
        {
            return dd('404');
        }

        // We get the post from the annotation
        $form = $this->createForm(PostType::class, $post);
        
        // We handle the request when sent
        $form->handleRequest($request);

        // verify if form is correct
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

    #[Route('/{id}/delete', name:'delete', methods:['GET','DELETE'])]
    public function delete(Post $post, EntityManagerInterface $em)
    {

        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        if($user->getId() != $post->getUser()->getId())
        {
            return dd('404');
        }

        $em->remove($post);
        $em->flush();
        return $this->redirectToRoute('home', ['Article modifié'], Response::HTTP_SEE_OTHER);
    }
}
