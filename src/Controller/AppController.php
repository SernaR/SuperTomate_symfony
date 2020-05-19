<?php

namespace App\Controller;

use App\Entity\Recipe;
use App\Entity\Comment;
use App\Form\CommentType;
use App\Repository\TagRepository;
use App\Repository\RecipeRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\RecipeHighlightRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AppController extends AbstractController
{
    /**
     * @Route("recettes/{categorySlug}/{recipeSlug}", name="app_recipe")
     */
    public function getRecipe(Request $request, EntityManagerInterface $em, RecipeRepository $recipeRepository, $recipeSlug) {
        
        $recipe = $recipeRepository->findOneBy(['slug' => $recipeSlug]);
        $comment = new Comment();

        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
    
            $recipe->addComment($comment);        
            $em->flush();

            return $this->redirectToRoute('app_recipe', [
                'categorySlug' => $recipe->getCategory()->getSlug(), 
                'recipeSlug' => $recipeSlug, 
            ]);
        }

        return $this->render('app/recipePages/recipe.html.twig', [
            'form' => $form->createView(),
            'recipe' => $recipe
        ]);
    }

    /**
     * @Route("recettes/{categorySlug}", name="app_category_recipes")
     */
    public function getCategoryRecipes(RecipeRepository $recipeRepository, TagRepository $tagRepository, $categorySlug) 
    {
        $recipes = $recipeRepository->recipesPerCategory($categorySlug);
        return $this->render('app/recipePages/categoryRecipes.html.twig', [
            'recipes' => $recipes,
            'tags' => $tagRepository->findAll(),
            'category' => $recipes ? $recipes[0]->getcategory()->getName() : $categorySlug
        ]);
    }

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
