<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Post;
use App\Repository\CommentRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class CommentController extends AbstractController
{
    #[Route('/add', name:'add', methods:['GET', 'POST'])]
    public function add(UserInterface $user, Request $request, EntityManagerInterface $em){
    
        // Verify if user is connected
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $newComment = new Comment();

        // Create form with the template we configured in \Form\PostType
        // we target our new post
        $form = $this->createForm(CommentType::class, $newComment);

        // We auto configure the date so it setup itself to the current date
        $newComment->setCreatedAt(new DateTimeImmutable('now'));

        // We set the User to the connected user we get from UserInterface
        $newComment->setUser($user);

        // Verify that the request is sent
        $form->handleRequest($request);

        // Verify if form is correct
        if($form->isSubmitted() && $form->isValid())
        {
            // register the new Comment
            $em->persist($newComment);
            $em->flush($newComment);

            // Redirect to homepage
            return $this->redirectToRoute('home', ['Commentaire créé'], Response::HTTP_CREATED);
        }

        // The way to the form
        return $this->renderForm('comment/_add.html.twig', [
            'comment' => $newComment,
            'form' => $form,
        ]);
    }

    /**
     * Edit a comment
     * Need to be connected and owner of the said comment
     */
    #[Route('/{id}/edit', name:'edit', methods:['GET', 'comment'])]
    public function edit(UserInterface $user , comment $comment, EntityManagerInterface $em, Request $request)
    {
        // Check if we are connected
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        // Check if connected user id correspond to the comment user id
        if($user->getId() != $comment->getUser()->getId())
        {
            return dd('404');
        }

        // We get the comment from the annotation
        $form = $this->createForm(commentType::class, $comment);
        
        // We handle the request when sent
        $form->handleRequest($request);

        // verify if form is correct
        if($form->isSubmitted() && $form->isValid())
        {
            $em->persist($comment);
            $em->flush($comment);

            return $this->redirectToRoute('home', ['Article modifié'], Response::HTTP_SEE_OTHER);
        }
        return $this->renderForm('comment/_add.html.twig', [
            'comment' => $comment,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/delete', name:'delete', methods:['GET','DELETE'])]
    public function delete(comment $comment, EntityManagerInterface $em)
    {

        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        if($user->getId() != $comment->getUser()->getId())
        {
            return dd('404');
        }

        $em->remove($comment);
        $em->flush();
        return $this->redirectToRoute('home', ['Article modifié'], Response::HTTP_SEE_OTHER);
    }
}
