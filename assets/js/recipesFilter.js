const tags = []
let name = ''
let $cards = $('.filtered-list')

$( document ).ready(function() {    
    $('.tag-filter').change(function() { filterByTag(this) })
    $('#recipeName-filter').focus().keyup( function() { filterByName(this) })
    $('#clear-filter').click( function() { clearFilters() })
})

/**
 * filter recipe by tag selected in checkbox
 */
const filterByTag = (tag) => {
    if ($(tag).is(':checked')) {
        tags.push(tag.value)
    }
    else {
        var pos = tags.indexOf(tag.value);
        tags.splice(pos, 1);
    }
    filterRecipe ()
}

/**
 * filter recipe by name keyed in input
 */
const filterByName = (input) => {
    name = $(input).val();
    filterRecipe()
}

/**
 * filter recipe if name or tag selected
 */
function filterRecipe () {

    $cards.show()
    $cards.each(function() {

        const isNameFound = 
            $(this).find('.js-recipeName').text().toLowerCase().includes(name) 
            ||
            $(this).find('.js-recipeName').text() === ""

        let isTagFound = false
        $(this).find('.js-recipeTags').each( function() {
           if ( tags.includes($(this).text()) && !isTagFound ) isTagFound = !isTagFound   
        })

        if((!isTagFound && tags.length > 0) || !isNameFound){ 
            $(this).hide()
        }
    })
}

/**
 * clear all filter
 */
const clearFilters = () => {
    $('#filtered-list div').show()
    $('#recipeName-filter').val('')
    $('.tag-filter').prop('checked', false);
}

