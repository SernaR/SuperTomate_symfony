
const url = 'https://127.0.0.1:8000/utilisateur/lecture/commentaire/'
const title = $('#js-read-count-title')
let count = parseInt( title.text() )

$('.js-read').each( function() {
    $(this).click( function(e) {
        event.preventDefault()

        const id = $(this).data('id')
        const plop = isReadedComment(id)
        .then( (response) => {
          if(response) {
            $(this).parent().parent().slideUp()
            title.text( --count )
          }else {
            alert('oups, une erreur est survenue')
          }
        })
    })
})

/**
 * appel à l'api met un statut lu au commentaire
 * @param {*} id 
 */
const isReadedComment = async (id) => {
    const rawResponse = await fetch( url + id, {
    method: 'PUT',
    headers: {
      'Accept': 'application/json',
      'Content-Type': 'application/json'
    }
  })
  
  const content = await rawResponse.json();
  return content.status === 200  
}
