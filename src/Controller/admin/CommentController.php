<?php

namespace App\Controller\admin;

use Error;
use App\Entity\Comment;
use App\Repository\CommentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("administrateur")
 */
class CommentController extends AbstractController
{
    /**
     * @Route("/commentaires", name="admin_comments")
     */
    public function index(CommentRepository $commentRepository)
    {
        
        return $this->render('app/adminPages/comments.html.twig', [
            'current_menu' => 'comments',
            'comments' => $commentRepository->findBy(['isChecked' => false])
        ]);
    }

    /**
     * @Route("/validation/commentaire/{comment}", methods={"PUT"})
     */
    public function validateComment(EntityManagerInterface $manager, Comment $comment)
    {
        try {
            $comment->setIsChecked(true);
            $manager->flush();

            return $this->json([
                'status' => 200,
                'comment' => $comment->getIsReaded(),
            ], 200);

        }catch(Error $e) {
            return $this->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

     /**
     * @Route("/bloque/commentaire/{comment}", methods={"PUT"})
     */
    public function blockComment(EntityManagerInterface $manager, Comment $comment)
    {
        try {
            $comment->setIsChecked(true);
            $comment->setIsBlocked(true);
            $manager->flush();

            return $this->json([
                'status' => 200,
                'comment' => $comment->getIsReaded(),
            ], 200);

        }catch(Error $e) {
            return $this->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
