

const tags = []

exports.setRecipeByCategoryFilters = () => {
    $('.tag-filter').change(function() { filterByTag(this) })
    $('#recipeName-filter').focus().keyup( function() { filterByName(this) })
    $('#clear-filter').click( function() { clearFilters() })
}

/**
 * filter recipe by tag params
 */
const filterByTag = (tag) => {
    if ($(tag).is(':checked')) {
        tags.push(tag.value)
    }
    else {
        var pos = tags.indexOf(tag.value);
        tags.splice(pos, 1);
    }

    $('#filtered-list div').show()
    $('#filtered-list').find('.card-body').each( function() {
        var isTagFound = false  
        $(this).find('span').each( function() {
            var isTagSelected = tags.includes( $(this).text() )
            if(isTagSelected){
                isTagFound = true
                return    
            } 
        });

        filterRecipe( isTagFound, $(this) )
    });
}

/**
 * filter recipe by name keyed in input
 */
const filterByName = (input) => {
    var value = $(input).val();

    $('#filtered-list div').show()
    $('#filtered-list').find('h3').each( function() {
        var isNameFound = $(this).text().toLowerCase().includes(value)
        filterRecipe( isNameFound, $(this) )
    });
}

/**
 * filter recipe with params displayed
 * @param  isItemFound 
 * @param  context 
 */
function filterRecipe (isItemFound, $context) {
    if(!isItemFound){
        $context.parent().parent().hide();
    }
}

/**
 * clear all filter
 */
const clearFilters = () => {
    $('#filtered-list div').show()
    $('#recipeName-filter').val('')
    $('.tag-filter').prop('checked', false);
}

