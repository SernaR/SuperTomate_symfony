<?php

namespace App\Controller\admin;

use Error;
use App\Entity\Tag;
use App\Entity\Recipe;
use App\Service\RecipeUtils;
use function PHPSTORM_META\map;
use App\Form\ValidateRecipeType;
use App\Repository\TagRepository;
use App\Form\RecipeDescriptionType;
use App\Repository\RecipeRepository;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("administrateur")
 */
class RecipeController extends AbstractController
{
    private $manager;
    
    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }
    /**
     * @Route("/recettes", name="admin_recipes")
     */
    public function validate(Request $request, RecipeRepository $recipeRepository)//, RecipeUtils $recipeUtils
    {   
        $recipe = $recipeRepository->findOneBy([
            'isChecked' => false,
            'isDraft' => false
        ]);
        
        //a remettre quand branchement du js**************************
        //$originalIngredients = $recipeUtils->setOriginalIngredients($recipe);
        //$originalSteps = $recipeUtils->setOriginalSteps($recipe);
        
        $form = $this->createForm(ValidateRecipeType::class, $recipe);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
 
            /*$ingredients = $recipe->getIngredients();
            $steps = $recipe->getSteps();
 
            if ($originalIngredients) {
                $recipeUtils->removeItem($originalIngredients, $ingredients, $this->manager);
                $recipeUtils->removeItem($originalSteps, $steps, $this->manager);
            }
 
            $recipeUtils->setRank($ingredients);
            $recipeUtils->setRank($steps);*/

            $recipe->setIsChecked(true);
            $this->manager->flush();
            
            return $this->redirectToRoute('admin_recipe_description', [
                'recipe' => $recipe->getId(),
            ]);
        }
    
        return $this->render('app/adminPages/recipes.html.twig', [
            'form' => $form->createView(),
            'recipe' => $recipe,
            'current_menu' => 'admin'
        ]);
    }

    /**
     * @Route("/description/{recipe}", name="admin_recipe_description")
     */
    public function metaDescription(Request $request, Recipe $recipe, TagRepository $tagRepository)
    { 
        $form = $this->createForm(RecipeDescriptionType::class, $recipe);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->flush();
            
            return $this->redirectToRoute('admin_recipes');
        }
    
        return $this->render('app/adminPages/description.html.twig', [
            'form' => $form->createView(),
            'recipe' => $recipe->getName(),
            'recipeId' => $recipe->getId(),
            'tags' => $tagRepository->findAll(),
            'current_menu' => 'admin'
        ]);
    }

    /**
     * @Route("/recipe/addTag/{recipe}/{tag}", name="api_add_recipe_tag", methods={"PUT"})
     */
    public function addRecipeTag(Recipe $recipe, Tag $tag) 
    {
        try {
            $recipe->addTag($tag);
            $this->manager->flush();

            return $this->json(['recipeId'=>  $recipe->getId()], 201);

        }catch(Error $e) {
            return $this->json([
                'message' => $e->getMessage()
            ], 403);
        }
    }

    /**
     * @Route("/recipe/removeTag/{recipe}/{tag}", name="api_remove_recipe_tag", methods={"PUT"})
     */
    public function removeRecipeTag(Recipe $recipe, Tag $tag) 
    {
        try {
            $recipe->removeTag($tag);
            $this->manager->flush();

            return $this->json(['recipeId'=>  $recipe->getId()], 201);

        }catch(Error $e) {
            return $this->json([
                'message' => $e->getMessage()
            ], 403);
        }
    }
}
