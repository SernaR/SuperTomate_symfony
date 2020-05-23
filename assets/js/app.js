
import '../css/app.css';
import './collections'
import  './recipesFilter'
import './comments'
import './tags'

$( document ).ready(function() {

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



