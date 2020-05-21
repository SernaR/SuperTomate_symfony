<?php

namespace App\Controller\admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("administrateur")
 */
class CommentController extends AbstractController
{
    /**
     * @Route("/commentaires", name="admin_comments")
     */
    public function index()
    {
        return $this->render('app/adminPages/comments.html.twig', [
            'current_menu' => 'comments'
        ]);
    }
}
