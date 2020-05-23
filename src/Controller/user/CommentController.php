<?php

namespace App\Controller\user;

use App\Entity\Comment;
use App\Repository\CommentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Error;
//use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
//use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("utilisateur")
 */
class CommentController extends AbstractController
{
    /**
     * @Route("/commentaires", name="user_comments")
     */
    public function index(CommentRepository $commentRepository)
    {
        return $this->render('app/userPages/comments.html.twig', [
            'comments' => $commentRepository->findBy(['isReaded' => false]),
            'current_menu' => 'comments'
        ]);
    }

    /**
     * @Route("/lecture/commentaire/{comment}", methods={"PUT"})
     */
    public function readComment(EntityManagerInterface $manager, Comment $comment)
    {
        try {
            $comment->setIsReaded(true);
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
