import tagAPI from './services/tagAPI'

let tagCounter = 0
const recipeId = $('#js-tag-selection-recipe').data('recipe')

$('span.js-tag-selection').each(function() {
    $(this).click( async function(event){
        event.preventDefault()
        
        const id = $(this).data('id')
        const selected = $(this).data('selected')
        
        if (!selected && tagCounter < 3) {
            try {
                await tagAPI.addTag(recipeId, id)
                tagCounter++
            } catch (error) {
                alert('oups, une erreur est survenue')
                return
            }      
        } else if (selected) {
            try {
                await tagAPI.removeTag(recipeId, id)
                tagCounter--
            } catch (error) {
                alert('oups, une erreur est survenue')
                return
            } 
        } else {
            return
        }
        switchClass( $(this))
        $(this).data('selected', !selected)

    })

}) 

function switchClass( $element) {
    $element.toggleClass( 'badge-secondary' )
    $element.toggleClass( 'badge-primary' )   
}





