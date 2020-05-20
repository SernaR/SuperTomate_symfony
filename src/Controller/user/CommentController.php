<?php

namespace App\Controller\user;

use App\Repository\CommentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

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
        return $this->render('app/userPages/userComments.html.twig', [
            'comments' => $commentRepository->findBy(['isReaded' => false]),
            'current_menu' => 'comments'
        ]);
    }
}
