<?php

namespace App\Controller\admin;

use Error;
use App\Entity\Recipe;
use App\Entity\Tag;
use App\Repository\TagRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("administrateur/api")
 */
class ApiController extends AbstractController
{
    private $manager;
   
    
    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
       
    }
    /**
     * @Route("/tags", name="api_tags", methods={"GET"})
     */
    /*
    public function getTags(TagRepository $tagRepository)
    {
        return $this->json($tagRepository->findAll(), 200, [], ['groups' => 'tags']);
    }*/

    /**
     * @Route("/recipe/addTag/{recipe}/{tag}", name="api_add_recipe_tag", methods={"PUT"})
     */
    public function addRecipeTag(Recipe $recipe, Tag $tag) 
    {
        //$json = $request->getContent();
        try {
            //$tag = $this->serializer->deserialize($json, Tag::class, 'json');
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
        //$json = $request->getContent();
        try {
            //$tag = $this->serializer->deserialize($json, Tag::class, 'json');
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
