<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Form\CommentType;

use App\Repository\TagRepository;
use App\Repository\RecipeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("recettes")
 */
class RecipeController extends AbstractController
{
    const MESSAGE =  'votre commentaire va être soumis à moderation';

    /**
     * @Route("/{categorySlug}/{recipeSlug}", name="app_recipe")  
     * 
     */
    public function getRecipe(Request $request, EntityManagerInterface $em, RecipeRepository $recipeRepository, $recipeSlug, $message = false) {
         
        $recipe = $recipeRepository->findOneBy(['slug' => $recipeSlug]);
        $message = isset($_GET['message']) ? self::MESSAGE : null;

        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
    
            $recipe->addComment($comment);        
            $em->flush();

            return $this->redirectToRoute('app_recipe', [
                'categorySlug' => $recipe->getCategory()->getSlug(), 
                'recipeSlug' => $recipeSlug,
                'message' => true
            ]);
        }

        return $this->render('app/recipePages/recipe.html.twig', [
            'form' => $form->createView(),
            'message' => $message, 
            'recipe' => $recipe
        ]);
    }

    /**
     * @Route("/{categorySlug}", name="app_category_recipes")
     */
    public function getCategoryRecipes(RecipeRepository $recipeRepository, TagRepository $tagRepository, $categorySlug) 
    {
        $recipes = $recipeRepository->recipesPerCategory($categorySlug);
        return $this->render('app/recipePages/categoryRecipes.html.twig', [
            'recipes' => $recipes,
            'tags' => $tagRepository->findAll(),
            'category' => $recipes ? $recipes[0]->getcategory()->getName() : $categorySlug,
            'current_menu' => $categorySlug
        ]);
    }
}
