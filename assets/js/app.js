
import '../css/app.css';
//import './addRecipe'
import { addRecipeCollectionHandler } from './addRecipe'
import { setRecipeByCategoryFilters } from './categoryRecipes'
import  './readComments'
//import { setRecipeByCategoryFilters } from './test'
import './Tagsmanagment'

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



