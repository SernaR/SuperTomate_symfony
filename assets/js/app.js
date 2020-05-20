
import '../css/app.css';
import { addRecipeCollectionHandler } from './addRecipe'
import { setRecipeByCategoryFilters } from './categoryRecipes'
//import { setRecipeByCategoryFilters } from './test'

$( document ).ready(function() {

    setRecipeByCategoryFilters()
    addRecipeCollectionHandler()

    /**
     * fermeture des message de confirmation
     */
    $('#js-message').click(function(){
        $(this).parent().slideUp();
    });

    /**
     * scroll auto si message
     */
    let searchParams = new URLSearchParams(window.location.search) 
    if(searchParams.has('message'))
        $('html, body').animate({scrollTop: $('#new-comment').offset().top -100 }, 'fast');


     
})



