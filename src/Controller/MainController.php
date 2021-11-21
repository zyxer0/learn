<?php

namespace App\Controller;

use App\Repository\RecipeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route ("/")
     */
    public function main(
        RecipeRepository $recipeRepository
    ): Response
    {
//        $recipes = $recipeRepository->findAll();
        $recipes = $recipeRepository->findBy(
            [],
            null,
            10,
            10
        );

        $recipe = reset($recipes);

//        print_r([
//            $recipe->getAuthor()->getName(),
//            $recipe->getIngredients()[2]->getName(),
//            $recipe->getIngredients()[2]->getAmount(),
//            $recipe->getIngredients()[2]->getAmountUnit()->getName(),
//        ]);

        return $this->render('main.html.twig', [
            'recipes' => $recipes,
        ]);
    }
}