import commentAPI from "./services/commentAPI"

const title = $('#js-count-comments')
let commentCounter = parseInt( title.text() )

$( document ).ready(function() {

  setActionBtn('.js-read-comment', commentAPI.readComment )
  setActionBtn('.js-validate-comment', commentAPI.validateComment )
  setActionBtn('.js-block-comment', commentAPI.blockComment )

})

function setActionBtn(selector, apiCall) {
  $(selector).each( function() {
    $(this).click( async function(event) {
      event.preventDefault()
      const id = $(this).data('id')

      try {
        await apiCall(id)
        $(this).parent().parent().slideUp()
        title.text( --commentCounter )
      } catch (error) {
          alert('oups, une erreur est survenue')
      } 
    })
})
}