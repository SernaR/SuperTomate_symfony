
import '../css/app.css';
import { addRecipeCollectionHandler } from './addRecipe'
import { setRecipeByCategoryFilters } from './categoryRecipes'
//import { setRecipeByCategoryFilters } from './test'

$( document ).ready(function() {

    setRecipeByCategoryFilters()
    addRecipeCollectionHandler()

    
})



