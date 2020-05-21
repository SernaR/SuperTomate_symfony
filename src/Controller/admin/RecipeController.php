<?php

namespace App\Controller\admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("administrateur")
 */
class RecipeController extends AbstractController
{
    /**
     * @Route("/recettes", name="admin_recipes")
     */
    public function index()
    {
        return $this->render('app/adminPages/recipes.html.twig', [
            'current_menu' => 'admin'
        ]);
    }
}
