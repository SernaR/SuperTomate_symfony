<?php

namespace App\Controller;

use App\Repository\RecipeRepository;
use App\Repository\RecipeHighlightRepository;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AppController extends AbstractController
{
    /**
     * @Route("/", name="app_homepage")
     */
    public function index(RecipeRepository $recipeRepository, RecipeHighlightRepository $recipeHighlightRepository)
    {
        return $this->render('app/homepage.html.twig', [
            'recipes' => $recipeRepository->lastRecipes(),
            'headline' =>$recipeHighlightRepository->headline()
        ]);
    }
}
