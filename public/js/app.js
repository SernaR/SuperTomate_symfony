$( document ).ready(function() {

    var tags = []

    //filtrer par mot-clé
    $('.tag-filter').change(function() {
        if ($(this).is(':checked')) {
            tags.push(this.value)
        }
        else {
            var pos = tags.indexOf(this.value);
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
    }); 

    //filtrer par nom
    $('#recipeName-filter').focus().keyup( function(event) {
        var value = $(this).val();

        $('#filtered-list div').show()
        $('#filtered-list').find('h3').each( function() {

            var isNameFound = $(this).text().toLowerCase().includes(value)
            
            filterRecipe( isNameFound, $(this) )
        });
    });

    function filterRecipe (isItemFound, context) {
        if(!isItemFound){
            context.parent().parent().hide();
        }
    }

    //vider le filtre
    $('#clear-filter').click( function() {
        $('#filtered-list div').show()
        $('#recipeName-filter').val('')
        $('.tag-filter').prop('checked', false);
    })
});

