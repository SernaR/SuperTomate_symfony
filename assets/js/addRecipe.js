exports.addRecipeCollectionHandler = () => {
    addPlusButton('.js-steps').click( function() { addNewForm( $(this), 'textarea' )})
    addPlusButton('.js-ingredients').click( function(){ addNewForm( $(this), 'input')})
        
}

/**
 * display collectionHolder with delete buttons
 * @param collection 
 * 
 */
const addPlusButton = (collection) => {
    
    let $collectionHolder = $(collection)
    const $addItem = $('<a"><i class="fas fa-plus-square mx-2 text-primary pointer"></i></a>')
    $collectionHolder.append($addItem)

    $collectionHolder.data('index', $collectionHolder.find('li').length)
    $collectionHolder.find('li').each(function () {
        addRemoveButton($(this).find('.row'))

    })
    return $addItem
}


/*
* creates a new form and appends it to the collectionHolder
*/
const addNewForm = ( $button, type ) => {

    let $collectionHolder = $button.parent()
    const prototype = $collectionHolder.data( 'prototype' )
    const index = $collectionHolder.data( 'index' )
    
    let newForm = prototype
    newForm = newForm.replace( /__name__/g, index )
    $collectionHolder.data('index', index + 1)
    
    let $newFormLi = $('<li></li>')
    let $newFormRow = $('<div class="row"></div>')
    let $newFormCol = $('<div class="col-sm-11 mb-2"></div>')

    $newFormCol.append( $(newForm).find(type) )
    $newFormRow.append( $newFormCol )
    $newFormLi.append( $newFormRow )
        
    addRemoveButton( $newFormRow )
    $button.before( $newFormLi)
}

/**
 * adds a remove button to the row that is passed in the parameter
 * @param $formRow
 */
const addRemoveButton = ($formRow) => {
    const $removeButton = $('<a><i class="fas fa-trash-alt mx-2 text-danger pointer"></i></a>')
    $formRow.append($removeButton);

    $removeButton.click(function (e) {
        e.preventDefault()
        $formRow.parent().slideUp(1000, function () {
            $(this).remove()
        }) 
    })
}


