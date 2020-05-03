$( document ).ready(function() {
    $('#recipeName-filter').focus().keyup( function(event) {
        var value = $(this).val();

        $('#filtered-list div').show()
        $('#filtered-list').find('h3').each( function() {
            var name = $(this);
            var result = name.text().toLowerCase().includes(value)
            if(!result){
                name.parent().parent().hide();
            }
        });
    });
});

/*
$("input[type='checkbox']:checked").each(
    function() {
     console.log($(this).attr('id'));
    });          
   }
);*/