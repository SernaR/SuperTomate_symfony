
var tags = []

$( document ).ready(function() {
    //////////////////////////////////////////////////////////////////////////////////////////
    //recipe by category
    //////////////////////////////////////////////////////////////////////////////////////////

    /**
     * filter recipe by tag params
     */
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

    /**
     * filter recipe by name keyed in input
     */
    $('#recipeName-filter').focus().keyup( function(event) {
        var value = $(this).val();

        $('#filtered-list div').show()
        $('#filtered-list').find('h3').each( function() {

            var isNameFound = $(this).text().toLowerCase().includes(value)
            
            filterRecipe( isNameFound, $(this) )
        });
    });

    /**
     * filter recipe with params displayed
     * @param  isItemFound 
     * @param  context 
     */
    function filterRecipe (isItemFound, context) {
        if(!isItemFound){
            context.parent().parent().hide();
        }
    }

    /**
     * clear all filter
     */
    $('#clear-filter').click( function() {
        $('#filtered-list div').show()
        $('#recipeName-filter').val('')
        $('.tag-filter').prop('checked', false);
    })

    //////////////////////////////////////////////////////////////////////////////////////////
    //addRecipe
    //////////////////////////////////////////////////////////////////////////////////////////
    
    setAddButton('.js-steps', 'textarea').on('click', function (e) {
        e.preventDefault();
        addNewForm( $(this), 'textarea');
    })

    setAddButton('.js-ingredients', 'input').on('click', function (e) {
        e.preventDefault();
        addNewForm( $(this), 'input');
    })
    

    /**
     * display collectionHolder with delete buttons
     * @param collection 
     * 
     */
    function setAddButton(collection) {
        
        $collectionHolder = $(collection);
        $addItem = $('<a"><i class="fas fa-plus-square mx-2 text-primary pointer"></i></a>');
        $collectionHolder.append($addItem);

        $collectionHolder.data('index', $collectionHolder.find('li').length)
        $collectionHolder.find('li').each(function () {
            addRemoveButton($(this).find('.row'));
    
        });
        return $addItem
    }


    /*
    * creates a new form and appends it to the collectionHolder
    */
    function addNewForm( $button, type ) {

        $collectionHolder = $button.parent()
        var prototype = $collectionHolder.data('prototype');
        var index = $collectionHolder.data('index');
        
        var newForm = prototype;
        newForm = newForm.replace(/__name__/g, index);
        $collectionHolder.data('index', index + 1);
        
        var $newFormLi = $('<li></li>');
        var $newFormRow = $('<div class="row"></div>');
        var $newFormCol = $('<div class="col-sm-11 mb-2"></div>');

        $newFormCol.append($(newForm).find(type))
        $newFormRow.append($newFormCol)
        $newFormLi.append($newFormRow)
           
        addRemoveButton($newFormRow);
        $button.before( $newFormLi);
    }

    /**
     * adds a remove button to the row that is passed in the parameter
     * @param $formRow
     */
    function addRemoveButton ($formRow) {
        var $removeButton = $('<a><i class="fas fa-trash-alt mx-2 text-danger pointer"></i></a>');
        $formRow.append($removeButton);

        $removeButton.click(function (e) {
            e.preventDefault();
            $formRow.parent().slideUp(1000, function () {
                $(this).remove();
            }) 
        });
    };

});


